<?php

declare(strict_types=1);

namespace Backend\Api\Helpers;

use InvalidArgumentException;
use JsonException;

class JsonHelper
{
    public function hydrateArrayToResponse($response)
    {
        $data = [];
        $data['type'] = 'error';

        if (is_array($response) && count($response) > 0) {
            $data['type'] = 'success';
            $data['response'] = $response['message'];
        }

        $this->buildJsonResponse($data);
    }

    public function buildJsonResponse($data)
    {
        header('Content-Type: application/json');
        header('Cache-Control: no-chache, no-store, must-revalidate');
        header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE');

        echo json_encode($data);
        exit;
    }

    /**
     * Handle the data retrieved by post requisition
     *
     * @return void
     */
    public static function handleRequestBodyJson()
    {
        try {
            $postJson = json_decode(file_get_contents('php://input'), true);
        } catch (JsonException $jsonException) {
            throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_EMPTY_JSON);
        }

        if (is_array($postJson) && count($postJson) > 0) {
            return $postJson;
        }
    }
}