<?php

class spLinkSearchProcessor extends modProcessor
{

    /**
     * @return array|string
     */
    public function process()
    {
        $c = $this->modx->newQuery('spLink', ['User.user' => $this->modx->user->id]);
        $c->innerJoin('spUserLink', 'User', 'User.link = spLink.id');
        $c->select('id');
        $links = ($c->prepare() && $c->stmt->execute())
            ? $c->stmt->fetchAll(PDO::FETCH_COLUMN)
            : [];

        $search = $this->modx->stripTags($this->getProperty('search'));
        $search = rtrim(str_replace(['https://', 'http://'], '', $search), '/');
        $c = $this->modx->newQuery('spLink', ['link:LIKE' => "%{$search}%"]);
        if (!empty($links)) {
            $c->where(['id:NOT IN' => $links]);
        }
        $c->select('link');
        $c->limit(100);
        $data = ($c->prepare() && $c->stmt->execute())
            ? $c->stmt->fetchAll(PDO::FETCH_COLUMN)
            : [];

        return $this->success('', $data);
    }

}

return 'spLinkSearchProcessor';