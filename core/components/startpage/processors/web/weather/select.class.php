<?php

class spCitySelectProcessor extends modProcessor
{
    const tpl = '@FILE chunks/_weather.tpl';


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$city = trim($this->getProperty('city'))) {
            return $this->failure($this->modx->lexicon('err_city_ns'));
        } elseif (!$object = $this->modx->getObject('spCity', ['city' => $city, 'OR:city_en:=' => $city])) {
            return $this->failure($this->modx->lexicon('err_city_nf'));
        }

        if ($this->modx->user->isAuthenticated($this->modx->context->key)) {
            $this->modx->user->getSettings();

            $key = ['user' => $this->modx->user->id, 'key' => 'weather'];
            /** @var modUserSetting $setting */
            if (!$setting = $this->modx->getObject('modUserSetting', $key)) {
                $setting = $this->modx->newObject('modUserSetting');
                $setting->fromArray($key, '', true);
            }
            $setting->set('value', $object->id);
            $setting->save();
        }

        /** @var Startpage $Startpage */
        $Startpage = $this->modx->getService('Startpage');

        return $this->success('', [
            'content' => $Startpage->getWeather($object->id, $this::tpl),
            'callback' => 'Weather.formCallback',
        ]);
    }
}

return 'spCitySelectProcessor';