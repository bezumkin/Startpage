<?php

class Startpage
{
    /** @var modX $modx */
    public $modx;
    /** @var pdoFetch $pdoTools */
    public $pdoTools;
    const assets_version = '1.06';


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = array())
    {
        $this->modx =& $modx;

        $corePath = $this->modx->getOption('startpage_core_path', $config,
            $this->modx->getOption('core_path') . 'components/startpage/'
        );
        $assetsUrl = $this->modx->getOption('startpage_assets_url', $config,
            $this->modx->getOption('assets_url') . 'components/startpage/'
        );
        $connectorUrl = $assetsUrl . 'connector.php';

        $this->config = array_merge(array(
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
            'imagesUrl' => $assetsUrl . 'images/',
            'connectorUrl' => $connectorUrl,

            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'chunksPath' => $corePath . 'elements/chunks/',
            'templatesPath' => $corePath . 'elements/templates/',
            'chunkSuffix' => '.chunk.tpl',
            'snippetsPath' => $corePath . 'elements/snippets/',
            'processorsPath' => $corePath . 'processors/',
        ), $config);

        $this->modx->addPackage('startpage', $this->config['modelPath']);
        $this->modx->lexicon->load('startpage:default');
        $this->pdoTools = $this->modx->getService('pdoFetch');
    }


    /**
     * @param modSystemEvent $event
     * @param array $scriptProperties
     */
    public function handleEvent(modSystemEvent $event, array $scriptProperties)
    {
        extract($scriptProperties);
        switch ($event->name) {
            case 'OnMODXInit':
                if (!empty($_GET['lang'])) {
                    $lang = strtolower(trim($this->modx->stripTags($_GET['lang'])));
                    if (in_array($lang, ['en', 'ru'])) {
                        $_SESSION['language'] = $lang;
                        $this->modx->config['cultureKey'] = $lang;
                    }
                    $request = preg_replace("#(\?|\&)lang={$lang}#", '', $_SERVER['REQUEST_URI']);
                    $this->modx->sendRedirect($request);
                } elseif (!empty($_SESSION['language'])) {
                    $this->modx->config['cultureKey'] = $_SESSION['language'];
                } else {
                    $this->modx->config['cultureKey'] = preg_match('#\bru\b#i', $_SERVER['HTTP_ACCEPT_LANGUAGE'])
                        ? 'ru'
                        : 'en';
                }
                // Save lang to user
                if ($this->modx->user->id) {
                    $extended = $this->modx->user->Profile->get('extended');
                    if (empty($extended['lang']) || $extended['lang'] != $this->modx->config['cultureKey']) {
                        $extended['lang'] = $this->modx->config['cultureKey'];
                        $this->modx->user->Profile->set('extended', $extended);
                        $this->modx->user->Profile->save();
                    }
                }
                // Load main lexicon
                $this->modx->lexicon->load('ru:startpage:default');
                $this->modx->lexicon->load('en:startpage:default');
                break;

            case 'pdoToolsOnFenomInit':
                /** @var Fenom|FenomX $fenom */
                $fenom->addAccessorSmart('en', 'en', Fenom::ACCESSOR_PROPERTY);
                /** @noinspection PhpUndefinedFieldInspection */
                $fenom->en = $this->modx->getOption('cultureKey') == 'en';

                $fenom->addAccessorSmart('assets_version', 'assets_version', Fenom::ACCESSOR_PROPERTY);
                /** @noinspection PhpUndefinedFieldInspection */
                $fenom->assets_version = $this::assets_version;
                break;

            case 'OnLoadWebDocument':
                if (!empty($_GET)) {
                    $this->modx->sendRedirect('/');
                }
                break;

            case 'OnPageNotFound':
                $this->modx->sendRedirect('/');
                break;

        }
    }


    /**
     * @param $action
     * @param array $data
     *
     * @return array|bool|mixed
     */
    public function loadAction($action, array $data = [])
    {
        return $this->runProcessor($action, $data);
    }


    /**
     * @param $action
     * @param array $data
     *
     * @return array|bool|mixed
     */
    public function runProcessor($action, array $data = [])
    {
        $action = 'web/' . trim($action, '/');
        /** @var modProcessorResponse $response */
        $response = $this->modx->runProcessor($action, $data, [
            'processors_path' => $this->config['processorsPath'],
        ]);
        if ($response) {
            $data = $response->getResponse();
            if (is_string($data)) {
                $data = json_decode($data, true);
            }

            return $data;
        }

        return false;
    }


    /**
     * @param $url
     * @param int $timeout
     *
     * @return array
     */
    public function checkLink($url, $timeout = 5)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);

        return $info;
    }


    /**
     * @param $city
     * @param string $tpl
     *
     * @return mixed
     */
    public function getWeather($city, $tpl = '')
    {
        /** @var Weather $Weather */
        $Weather = $this->modx->getService('Weather', 'Weather', MODX_CORE_PATH . 'components/startpage/model/');
        if ($data = $Weather->getCurrentWeather($city)) {
            $data['fact']['icon'] = $Weather->getImage($data['fact']['icon']);

            if ($this->modx->getOption('cultureKey') == 'ru') {
                $directions = array(
                    'n' => 'с',
                    'e' => 'в',
                    's' => 'ю',
                    'w' => 'з',
                );
                $data['fact']['wind_dir'] = strtr($data['fact']['wind_dir'], $directions);
            }
        }
        if (!empty($tpl)) {
            $data = $this->pdoTools->getChunk($tpl, ['weather' => $data]);
        }

        return $data;
    }

}