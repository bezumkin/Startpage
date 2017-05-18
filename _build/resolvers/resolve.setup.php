<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            /** @var modResource $resource */
            if ($resource = $modx->getObject('modResource', ['id' => $modx->getOption('site_start')])) {
                $resource->set('cacheable', false);
                /** @var modTemplate $template */
                if ($template = $modx->getObject('modTemplate', ['templatename' => 'BaseTemplate'])) {
                    $resource->set('template', $template->id);
                }
                $resource->save();
            }
            break;

        case xPDOTransport::ACTION_UNINSTALL:
            break;
    }
}

return true;