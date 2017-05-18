<?php
/** @var modX $modx */
/** @var array $sources */

$templates = array();

$tmp = array(
    'BaseTemplate' => array(
        'file' => 'base',
        'description' => '',
    ),
);

foreach ($tmp as $k => $v) {
    /** @var modTemplate $template */
    $template = $modx->newObject('modTemplate');
    $template->fromArray(array(
        'id' => 1,
        'templatename' => $k,
        'description' => $v['description'],
        'content' => file_exists($sources['source_core'] . "/elements/templates/{$v['file']}.tpl")
            ? "{include 'file:templates/{$v['file']}.tpl'}"
            : ''
    ), '', true, true);
    $templates[] = $template;
}
unset($tmp);

return $templates;