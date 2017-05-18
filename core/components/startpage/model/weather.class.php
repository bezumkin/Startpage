<?php

class Weather
{
    /** @var modX $modx */
    public $modx;
    const device_id = '549350E8942E3575';
    const user_id = 'a6e39f8b-a749-4cce-ac58-0e6ea5573824';
    const timeout = 1;


    /**
     * Weather constructor.
     *
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = array())
    {
        $this->modx = $modx;
        $this->lang = $this->modx->getOption('cultureKey');
        $this->config = array_merge([
            'service' => 'https://api.weather.yandex.ru/v1/forecast?lang=' . $this->lang . '&geoid=',
            'images' => 'https://yastatic.net/weather/i/icons/svg/',
            'cache_image' => MODX_ASSETS_URL . 'components/startpage/img/weather/',
            'cache_time' => 600,
            'cache_file' => 'weather_' . $this->lang . '_',
        ], $config);

    }


    /**
     * @param int $city
     *
     * @return array|mixed
     */
    public function getCurrentWeather($city = 0)
    {
        $key = $this->config['cache_file'] . $city;

        $cacheManager = $this->modx->getCacheManager();
        if (!$result = $cacheManager->get($key)) {
            $did = $this::device_id;
            $uuid = $this::user_id;
            $timestamp = time();
            $token = md5('eternalsun' . $timestamp);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->config['service'] . $city);
            curl_setopt($ch, CURLOPT_USERAGENT, 'yandex-weather-android/4.2.1');
            curl_setopt($ch, CURLOPT_TIMEOUT, $this::timeout);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-Yandex-Weather-Client: YandexWeatherAndroid/4.2.1',
                "X-Yandex-Weather-Device: os=null;os_version=21;manufacturer=chromium;model=App Runtime for Chrome Dev;device_id=$did;uuid=$uuid;",
                'X-Yandex-Weather-Token: ' . $token,
                'X-Yandex-Weather-Timestamp: ' . $timestamp,
                'X-Yandex-Weather-UUID: ' . $uuid,
                'X-Yandex-Weather-Device-ID: ' . $did,
                'Accept-Encoding: text/plain',
                'Host: api.weather.yandex.ru',
                'Connection: Keep-Alive',
            ));
            $result = curl_exec($ch);
            $info = curl_getinfo($ch);
            curl_close($ch);

            if ($info['http_code'] == 200) {
                $cacheManager->set($key, $result, $this->config['cache_time']);
            } else {
                $result = false;
            }
        }

        return !empty($result)
            ? json_decode($result, true)
            : [];
    }


    /**
     * @param $image
     * @param string $ext
     *
     * @return string
     */
    public function getImage($image, $ext = 'svg')
    {
        $image .= '.' . $ext;
        $path = ltrim($this->config['cache_image'], '/');
        $file = MODX_BASE_PATH . $path . $image;
        if (!file_exists($file)) {
            if ($data = file_get_contents($this->config['images'] . $image)) {
                file_put_contents($file, $data);
            } else {
                $image = '_empty.png';
            }
        }

        return '/' . $path . $image;
    }
}