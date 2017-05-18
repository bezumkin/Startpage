<?php

/**
 * @property string scheme
 * @property string link
 * @property string domain
 * @property int rank
 * @property bool update
 */
class spLink extends xPDOSimpleObject
{
    const format = 'jpg';
    const timeout = 20;
    const cache = 1;
    /** @var modFileMediaSource $mediaSource */
    public $mediaSource;


    /**
     * @return bool
     */
    public function initializeMediaSource()
    {
        $source = $this->xpdo->getOption('sp_source_default', 2);
        if ($this->mediaSource = $this->xpdo->getObject('sources.modMediaSource', $source)) {
            $this->mediaSource->set('ctx', 'web');
            $this->mediaSource->initialize();

            return true;
        }

        $this->xpdo->log(modX::LOG_LEVEL_ERROR,
            "Could not initialize media source {$source}"
        );

        return false;
    }


    /**
     * @return bool
     */
    public function getScreenshot()
    {
        if (!$this->initializeMediaSource()) {
            return false;
        }

        $properties = $this->mediaSource->getProperties();
        if (empty($properties['thumbnails']) || !$thumbnails = json_decode($properties['thumbnails']['value'], true)) {
            return false;
        }
        $params = [
            'key' => $this->xpdo->getOption('sp_api_key'),
            'dimension' => $thumbnails['large']['w'] . 'x' . $thumbnails['large']['h'],
            'device' => 'desktop',
            'format' => $this::format,
            'cacheLimit' => $this::cache,
            'timeout' => 500,
            'url' => $this->scheme . '://' . $this->link,
        ];
        $curl = curl_init();
        $url = 'http://api.screenshotmachine.com/?' . http_build_query($params);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this::timeout);
        if (!$screenshot = curl_exec($curl)) {
            $this->xpdo->log(xPDO::LOG_LEVEL_ERROR, 'Could not download a screenshot for ' . $this->link. ': ' . $url);

            return false;
        }
        $this->mediaSource->createContainer($this->id, '/');
        $this->mediaSource->removeObject($this->id . '/' . 'large.' . $this::format);
        $upload = urldecode($this->mediaSource->createObject($this->id . '/', 'large.' . $this::format, $screenshot));
        unset($thumbnails['large']);

        if ($this->makeThumbnails($upload, $thumbnails)) {
            $this->set('screenshots', true);
            $this->set('updatedon', date('Y-m-d H:i:s'));
            $this->save();

            $this->leanify(MODX_BASE_PATH . $properties['basePath']['value'] . $this->id . '/');

            return true;
        }

        return false;
    }


    /**
     * @param $image
     * @param $thumbnails
     *
     * @return bool
     */
    protected function makeThumbnails($image, $thumbnails)
    {
        if (!class_exists('modPhpThumb')) {
            /** @noinspection PhpIncludeInspection */
            require MODX_CORE_PATH . 'model/phpthumb/modphpthumb.class.php';
        }
        /** @noinspection PhpParamsInspection */
        $phpThumb = new modPhpThumb($this->xpdo);
        $phpThumb->initialize();

        foreach ($thumbnails as $name => $params) {
            $phpThumb->setSourceData(@file_get_contents($image));
            foreach ($params as $k => $v) {
                $phpThumb->setParameter($k, $v);
            }

            $phpThumb->setParameter('f', $this::format);
            if (!$phpThumb->GenerateThumbnail() || !$phpThumb->RenderOutput()) {
                $this->xpdo->log(modX::LOG_LEVEL_ERROR,
                    "Could not generate thumbnail for {$this->link}:" . print_r($phpThumb->debugmessages, true)
                );

                return false;
            }
            $name .= '.' . $this::format;
            $this->mediaSource->removeObject($this->id . '/' . $name);
            if (!$this->mediaSource->createObject($this->id . '/', $name, $phpThumb->outputImageData)) {
                $this->xpdo->log(modX::LOG_LEVEL_ERROR,
                    "Could not save thumbnail for {$this->link}:" . print_r($this->mediaSource->getErrors(), true)
                );

                return false;
            }
        }

        return true;
    }


    /**
     * @param $path
     */
    protected function leanify($path)
    {
        $leanify = MODX_CORE_PATH . 'components/startpage/cli/leanify';
        if (file_exists($leanify)) {
            if (!is_executable($leanify)) {
                chmod($leanify, 0777);
            }
            shell_exec("$leanify -i 15 -q $path");
        }
    }

}