<?php

class spLinkUpdateProcessor extends modObjectGetProcessor
{
    const tpl = '@FILE chunks/links/_link.tpl';
    /** @var spLink $object */
    public $object;
    public $classKey = 'spLink';


    /**
     * @return bool|null|string
     */
    public function initialize()
    {
        return !$this->modx->user->isAuthenticated($this->modx->context->key)
            ? $this->modx->lexicon('err_auth_update')
            : parent::initialize();
    }


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->object->update) {
            return $this->success();
        } elseif ($this->object->getScreenshot()) {
            /** @var pdoTools $pdoTools */
            $pdoTools = $this->modx->getService('pdoTools');

            return $this->success($this->modx->lexicon('success_link_update'), [
                'content' => $pdoTools->getChunk($this::tpl, [
                    'link' => $this->object->toArray(),
                ]),
            ]);
        }

        return $this->failure($this->modx->lexicon('err_link_update'));
    }

}

return 'spLinkUpdateProcessor';