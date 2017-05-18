<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $settings = [
                'friendly_urls' => true,
                'friendly_urls_strict' => true,
                'request_method_strict' => true,
                'link_tag_scheme' => 'abs',
                'pdotools_elements_path' => '{core_path}components/startpage/elements/',
                'pdotools_fenom_parser' => true,
            ];
            foreach ($settings as $key => $value) {
                /** @var modSystemSetting $setting */
                if ($setting = $modx->getObject('modSystemSetting', ['key' => $key])) {
                    $setting->set('value', $value);
                    $setting->save();
                }
            }
            break;

        case xPDOTransport::ACTION_UNINSTALL:
            break;
    }
}

return true;