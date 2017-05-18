<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var Startpage $Startpage */

if ($Startpage = $modx->getService('Startpage', 'Startpage', MODX_CORE_PATH . 'components/startpage/model/')) {
    $Startpage->handleEvent($modx->event, $scriptProperties);
}