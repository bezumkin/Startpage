<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var Startpage $Startpage */
$Startpage = $modx->getService('Startpage');
$tpl = $modx->getOption('tpl', $scriptProperties, '@FILE chunks/startpage.tpl');

$c = $modx->newQuery('spLink');
if (!$modx->user->isAuthenticated($modx->context->key)) {
    $c->sortby('rand()');
    $c->limit(14);
} else {
    $c->innerJoin('spUserLink', 'UserLink', 'UserLink.link = spLink.id');
    $c->where(['UserLink.user' => $modx->user->id]);
    $c->sortby('UserLink.rank', 'asc');
}
$c->select($modx->getSelectColumns('spLink', 'spLink'));
$time = microtime(true);
if ($c->prepare() && $c->stmt->execute()) {
    $modx->executedQueries++;
    $modx->queryTime += microtime(true) - $time;
    $data['links'] = $c->stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $data['links'] = [];
}

/** @var modUserSetting $setting */
if ($setting = $modx->getObject('modUserSetting', ['user' => $modx->user->id, 'key' => 'crawler'])) {
    $data['crawler'] = $setting->get('value');
} else {
    $data['crawler'] = $modx->getOption('cultureKey') == 'en'
        ? 'google'
        : 'yandex';
}
$modx->regClientScript('<script type="text/javascript">
    requirejs(["app", "app/search"], function(App) {App.Search.init("' . $data['crawler'] . '")});
</script>', true);

if ($setting = $modx->getObject('modUserSetting', ['user' => $modx->user->id, 'key' => 'weather'])) {
    $data['city'] = $setting->get('value');
} else {
    $data['city'] = $modx->getOption('cultureKey') == 'en'
        ? 10393 // London
        : 213; // Москва
}
$modx->regClientScript('<script type="text/javascript">
    requirejs(["app", "app/weather"], function(App) {App.Weather.init("' . $data['city'] . '")});
</script>', true);


if ($modx->user->hasSessionContext('mgr')) {
    //echo '<pre>';print_r($Startpage->getWeather('10393'));die;
}

return $Startpage->pdoTools->getChunk($tpl, $data);
