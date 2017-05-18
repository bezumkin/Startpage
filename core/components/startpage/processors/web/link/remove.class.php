<?php

class spLinkRemoveProcessor extends modObjectRemoveProcessor
{
    const tpl = '@FILE chunks/links/_link.tpl';
    /** @var spLink $object */
    public $object;
    public $classKey = 'spUserLink';


    /**
     * @return bool|null|string
     */
    public function initialize()
    {
        if (!$this->modx->user->isAuthenticated($this->modx->context->key)) {
            return $this->modx->lexicon('err_auth_remove');
        }

        $this->object = $this->modx->getObject($this->classKey, [
            'link' => $this->getProperty('id'),
            'user' => $this->modx->user->id,
        ]);

        return !empty($this->object);
    }

}

return 'spLinkRemoveProcessor';