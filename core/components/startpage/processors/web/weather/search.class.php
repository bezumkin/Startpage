<?php

class spCitySearchProcessor extends modProcessor
{

    /**
     * @return array|string
     */
    public function process()
    {
        $search = $this->modx->stripTags($this->getProperty('search'));
        $c = $this->modx->newQuery('spCity', ['active' => true]);
        $c->andCondition([
            'city:LIKE' => "%{$search}%",
            'OR:city_en:LIKE' => "%{$search}%",
        ]);
        $c->sortby('city', 'asc');
        $c->select($this->modx->getOption('cultureKey') == 'en' ? 'city_en' : 'city');
        $c->limit(100);
        $data = ($c->prepare() && $c->stmt->execute())
            ? $c->stmt->fetchAll(PDO::FETCH_COLUMN)
            : [];

        return $this->success('', $data);
    }

}

return 'spCitySearchProcessor';