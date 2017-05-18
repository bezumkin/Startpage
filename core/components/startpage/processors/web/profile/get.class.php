<?php

class spProfileGetProcessor extends modObjectProcessor
{
    /** @var modUserProfile $object */
    public $object;
    public $classKey = 'modUserProfile';
    public $languageTopics = array();
    const tpl = '@FILE chunks/hybridauth/profile.tpl';
    const tplProvider = '@FILE chunks/hybridauth/provider.tpl';
    const tplProviderActive = '@FILE chunks/hybridauth/provider-active.tpl';


    /**
     * @return bool
     */
    public function initialize()
    {
        return $this->modx->user->isAuthenticated($this->modx->context->key);
    }


    /**
     * @return array|string
     */
    public function process()
    {
        /** @var pdoTools $pdo */
        $pdo = $this->modx->getService('pdoTools');
        $_SERVER['REQUEST_URI'] = '/';
        /** @var HybridAuth $ha */
        $ha = $this->modx->getService('HybridAuth', 'HybridAuth',
            MODX_CORE_PATH . 'components/hybridauth/model/hybridauth/');
        $ha->initialize($this->modx->context->key);
        $content = $pdo->getChunk($this::tpl, [
            'profile' => $this->modx->user->Profile->toArray(),
            'providers' => $ha->getProvidersLinks(
                $this::tplProvider,
                $this::tplProviderActive
            ),
        ]);

        return $this->success('', [
            'title' => $this->modx->lexicon('title_edit_profile'),
            'content' => preg_replace('#(provider=.*?)"#s', '$1#profile"', $content),
        ]);
    }

}

return 'spProfileGetProcessor';