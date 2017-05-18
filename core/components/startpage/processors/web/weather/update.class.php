<?php

class spWeatherUpdateProcessor extends modProcessor
{
    const tpl = '@FILE chunks/_weather.tpl';


    /**
     * @return array|string
     */
    public function process()
    {
        /** @var Startpage $Startpage */
        $Startpage = $this->modx->getService('Startpage');
        $content = '';
        if ($city = (int)$this->getProperty('city')) {
            $content = $Startpage->getWeather($city, $this::tpl);
        }

        return $this->success('', [
            'content' => $content,
        ]);
    }
}

return 'spWeatherUpdateProcessor';