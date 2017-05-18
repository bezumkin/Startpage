<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            /** @var modX $modx */
            $modx =& $object->xpdo;

            $tmp = explode('/', MODX_ASSETS_URL);
            $assets = $tmp[count($tmp) - 2];

            $properties = array(
                'name' => 'Screenshots',
                'description' => 'Default media source for Startpage',
                'class_key' => 'sources.modFileMediaSource',
                'properties' => array(
                    'basePath' => array(
                        'name' => 'basePath',
                        'desc' => 'prop_file.basePath_desc',
                        'type' => 'textfield',
                        'lexicon' => 'core:source',
                        'value' => $assets . '/screenshots/',
                    ),
                    'baseUrl' => array(
                        'name' => 'baseUrl',
                        'desc' => 'prop_file.baseUrl_desc',
                        'type' => 'textfield',
                        'lexicon' => 'core:source',
                        'value' => $assets . '/screenshots/',
                    ),
                    'thumbnails' => [
                        'name' => 'thumbnails',
                        'desc' => '',
                        'type' => 'textfield',
                        'lexicon' => 'core:source',
                        'value' => '{"large":{"w":1280,"h":720},"small":{"w":304,"h":171},"small@2x":{"w":608,"h":342}}',
                    ],
                ),
                'is_stream' => 1,
            );
            /** @var modFileMediaSource $source */
            if (!$source = $modx->getObject('sources.modMediaSource', array('name' => $properties['name']))) {
                $source = $modx->newObject('sources.modMediaSource', $properties);
            } else {
                $source->fromArray($properties);
            }
            $source->save();

            /** @var modSystemSetting $setting */
            if ($setting = $modx->getObject('modSystemSetting', array('key' => 'sp_source_default'))) {
                $setting->set('value', $source->get('id'));
                $setting->save();
            }
            @mkdir(MODX_ASSETS_PATH . 'screenshots/');
            break;

        case xPDOTransport::ACTION_UNINSTALL:
            break;
    }
}
return true;