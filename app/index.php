<?php

use Backend\Api\Controllers\Controller;
use Backend\Api\Helpers\{JsonHelper, RoutesHelper};

require 'vendor/autoload.php';

ini_set("display_errors", 0);
ini_set("log_errors", 1);

try {
    $controller = new Controller(RoutesHelper::getRoutes());
    $response = $controller->handleRequest();

    $jsonHelper = new JsonHelper();
    $jsonHelper->hydrateArrayToResponse($response);
} catch (Exception $exception) {
    echo json_encode([
        'type' => 'error',
        'response' => $exception->getMessage()
    ], JSON_THROW_ON_ERROR, 512);
    exit;
}
