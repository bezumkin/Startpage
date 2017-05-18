<?php

class spProfileUpdateProcessor extends modObjectUpdateProcessor
{
    const tpl = '@FILE chunks/hybridauth/logout.tpl';
    /** @var modUserProfile */
    public $object;
    public $classKey = 'modUserProfile';
    /** @var Startpage $startpage */
    public $Startpage;


    /**
     * @return bool|null|string
     */
    public function initialize()
    {
        if (!$this->modx->user->isAuthenticated($this->modx->context->key)) {
            return $this->modx->lexicon('err_auth_profile');
        }
        $this->object = $this->modx->user->Profile;
        $this->Startpage = $this->modx->getService('Startpage');

        return true;
    }


    /**
     * @return bool|string
     */
    public function beforeSet()
    {
        if (!$fullname = $this->modx->stripTags($this->getProperty('fullname'))) {
            return $this->modx->lexicon('err_profile_name');
        }
        if ($photo = $this->modx->stripTags($this->getProperty('avatar'))) {
            $check = $this->Startpage->checkLink($photo);
            if (strpos($check['content_type'], 'image') === false) {
                return $this->modx->lexicon('err_profile_image');
            }
        }

        $this->properties = [
            'fullname' => $fullname,
            'photo' => $photo,
        ];

        return parent::beforeSet();
    }


    /**
     * @return array|string
     */
    public function cleanup()
    {
        return $this->success($this->modx->lexicon('success_profile'), [
            'callback' => 'Profile.callback',
            'content' => $this->Startpage->pdoTools->getChunk($this::tpl, [
                'photo' => $this->object->get('photo'),
                'fullname' => $this->object->get('fullname'),
                'gravatar' => 'https://gravatar.com/avatar/' . md5(strtolower($this->object->get('email'))),
                'logout_url' => $this->modx->getOption('site_url') . '?hauth_action=logout',
            ]),
        ]);
    }
}

return 'spProfileUpdateProcessor';