<?php

class spLinkSortProcessor extends modObjectGetProcessor
{
    /** @var spLink $object */
    public $object;
    public $classKey = 'spUserLink';


    /**
     * @return bool
     */
    public function initialize()
    {
        if (!$this->modx->user->isAuthenticated($this->modx->context->key)) {
            return false;
        }
        $this->object = $this->modx->getObject($this->classKey, [
            'link' => $this->getProperty('id'),
            'user' => $this->modx->user->id,
        ]);

        return !empty($this->object);

    }


    /**
     * @return array|string
     */
    public function process()
    {
        $from = $this->getProperty('from');
        $to = $this->getProperty('to');

        if ($from < $to) {
            $this->modx->exec("UPDATE {$this->modx->getTableName($this->classKey)}
                SET rank = rank - 1 WHERE
                    user = " . $this->modx->user->id . "
                    AND rank <= {$to}
                    AND rank > {$from}
                    AND rank > 0
            ");
        } else {
            $this->modx->exec("UPDATE {$this->modx->getTableName($this->classKey)}
                SET rank = rank + 1 WHERE
                    user = " . $this->modx->user->id . "
                    AND rank >= {$to}
                    AND rank < {$from}
            ");

        }
        $this->object->rank = $to;
        $this->object->save();
        $this->rankLinks();

        return $this->success();
    }


    /**
     *
     */
    protected function rankLinks()
    {
        $c = $this->modx->newQuery($this->classKey, ['user' => $this->modx->user->id]);
        $c->groupby('rank');
        $c->select('COUNT(rank) as idx');
        $c->sortby('idx', 'DESC');
        $c->limit(1);
        if ($c->prepare() && $c->stmt->execute()) {
            if ($c->stmt->fetchColumn() > 1) {
                // Update ranks
                $c = $this->modx->newQuery($this->classKey, ['user' => $this->modx->user->id]);
                $c->select('link');
                $c->sortby('rank ASC, createdon', 'ASC');
                if ($c->prepare() && $c->stmt->execute()) {
                    $table = $this->modx->getTableName($this->classKey);
                    $update = $this->modx->prepare("UPDATE {$table} SET rank = ? WHERE (user = ? AND link = ?)");
                    $links = $c->stmt->fetchAll(PDO::FETCH_COLUMN);
                    foreach ($links as $k => $link) {
                        $update->execute(array($k, $this->modx->user->id, $link));
                    }
                }
            }
        }
    }

}

return 'spLinkSortProcessor';