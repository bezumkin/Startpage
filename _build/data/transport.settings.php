<?php
/** @var modX $modx */
/** @var array $sources */

$settings = array();

$tmp = array(
    'api_key' => [
        'xtype' => 'textfield',
        'value' => '', // Your API key from https://www.screenshotmachine.com/account.php
        'area' => 'sp_main',
    ],
    'source_default' => [
        'xtype' => 'modx-combo-source',
        'value' => 2,
        'area' => 'sp_main',
    ],
);

foreach ($tmp as $k => $v) {
    /** @var modSystemSetting $setting */
    $setting = $modx->newObject('modSystemSetting');
    $setting->fromArray(array_merge([
        'key' => 'sp_' . $k,
        'namespace' => PKG_NAME_LOWER,
    ], $v), '', true, true);

    $settings[] = $setting;
}
unset($tmp);

return $settings;
