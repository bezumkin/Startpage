<?php

class spLinkCreateProcessor extends modObjectCreateProcessor
{
    const tpl = '@FILE chunks/links/_link.tpl';
    /** @var spUserLink $object */
    public $object;
    public $classKey = 'spUserLink';
    /** @var Startpage $Startpage */
    public $Startpage;


    /**
     * @return bool|null|string
     */
    public function initialize()
    {
        if (!$this->modx->user->isAuthenticated($this->modx->context->key)) {
            return $this->modx->lexicon('err_auth_add');
        }
        $this->Startpage = $this->modx->getService('Startpage');

        return parent::initialize();
    }


    /**
     * @return bool
     */
    public function beforeSet()
    {
        if (!$link = $this->getProperty('link')) {
            return $this->modx->lexicon('err_link_ns');
        }
        if (strpos($link, '.') == false) {
            return $this->modx->lexicon('err_link_wrong');
        }

        if (!$object = $this->modx->getObject('spLink', ['link' => str_replace(['http://', 'https://'], '', $link)])) {
            $check = $this->Startpage->checkLink($link, 2);
            if (empty($check['http_code'])) {
                return $this->modx->lexicon('err_link_nf');
            }
            $url = parse_url(strtolower($check['url']));
            if (!empty($check['redirect_url'])) {
                if ($url['scheme'] == 'http') {
                    if (str_replace('http://', 'https://', strtolower($check['url'])) == $check['redirect_url']) {
                        $link = $check['redirect_url'];
                    }
                }
            } else {
                $link = str_replace('HTTP://', 'http://', $check['url']);
            }
            if ($url['path'] == '/') {
                $link = rtrim($link, '/');
            }

            /** @var spLink $object */
            $scheme = parse_url($link)['scheme'];
            $link = str_replace([$scheme, '://'], '', $link);
            $c = $this->modx->newQuery('spLink', ['link' => $link]);
            if (!$object = $this->modx->getObject('spLink', $c)) {
                $object = $this->modx->newObject('spLink');
                $object->set('scheme', $scheme);
                $object->set('link', $link);
                $object->set('domain', $url['host']);
                $object->set('createdon', date('Y-m-d H:i:s'));
                $object->save();
            }
        }
        $this->setProperty('link', $object->get('id'));

        return parent::beforeSet();
    }


    /**
     * @return bool|string
     */
    public function beforeSave()
    {
        $key = [
            'link' => $this->getProperty('link'),
            'user' => $this->modx->user->id,
        ];
        if ($this->doesAlreadyExist($key)) {
            return $this->modx->lexicon('err_link_ae');
        }
        $this->object->fromArray($key, '', true, true);
        $this->object->set('createdon', date('Y-m-d H:i:s'));
        $this->object->set('rank', $this->modx->getCount($this->classKey, ['user' => $this->modx->user->id]));

        return parent::beforeSave();
    }


    /**
     * @return array|string
     */
    public function cleanup()
    {
        $object = $this->modx->getObject('spLink', $this->object->link);

        return $this->success($this->modx->lexicon('success_link_add'), [
            'callback' => 'Links.formCallback',
            'id' => $object->id,
            'content' => $this->Startpage->pdoTools->getChunk($this::tpl, [
                'link' => $object->toArray(),
            ]),
        ]);
    }

}

return 'spLinkCreateProcessor';