<?php

function failure($message = '', array $data = [])
{
    $response = [
        'success' => false,
        'message' => $message,
        'data' => $data,
    ];
    @session_write_close();
    http_response_code(422);

    exit(json_encode($response));
}

if (empty($_REQUEST['action'])) {
    failure('Access denied');
}

/** @var modX $modx */
define('MODX_API_MODE', true);
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/index.php';
$modx->getService('error', 'error.modError');
$modx->getRequest();
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->setLogTarget('FILE');
$modx->error->reset();

/** @var Startpage $Startpage */
if ($Startpage = $modx->getService('Startpage', 'Startpage', MODX_CORE_PATH . 'components/startpage/model/')) {
    $action = str_replace(' ', '', $_REQUEST['action']);
    unset($_REQUEST['action']);
    if ($response = $Startpage->loadAction($action, $_REQUEST)) {
        if (empty($response['success'])) {
            http_response_code(422);
        }
        @session_write_close();
        exit(json_encode($response));
    }
}

failure('Unknown error');