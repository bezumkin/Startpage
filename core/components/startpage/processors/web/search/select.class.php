<?php

class spSearchSelectProcessor extends modProcessor
{
    /**
     * @return array|string
     */
    public function process()
    {
        if ($this->modx->user->isAuthenticated($this->modx->context->key)) {
            $this->modx->user->getSettings();

            $key = ['user' => $this->modx->user->id, 'key' => 'crawler'];
            /** @var modUserSetting $setting */
            if (!$setting = $this->modx->getObject('modUserSetting', $key)) {
                $setting = $this->modx->newObject('modUserSetting');
                $setting->fromArray($key, '', true);
            }
            $setting->set('value', $this->getProperty('crawler'));
            $setting->save();
        }

        return $this->success();
    }
}

return 'spSearchSelectProcessor';