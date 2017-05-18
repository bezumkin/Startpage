<?php

class spLinkGetProcessor extends modObjectProcessor
{
    const tpl = '@FILE chunks/links/form.tpl';


    /**
     * @return bool
     */
    public function initialize()
    {
        return !$this->modx->user->isAuthenticated($this->modx->context->key)
            ? $this->modx->lexicon('err_auth_get')
            : true;
    }


    /**
     * @return array|string
     */
    public function process()
    {
        /** @var pdoTools $pdo */
        $pdo = $this->modx->getService('pdoTools');

        return $this->success('', [
            'title' => $this->modx->lexicon('title_add_link'),
            'content' => $pdo->getChunk($this::tpl),
        ]);
    }

}

return 'spLinkGetProcessor';