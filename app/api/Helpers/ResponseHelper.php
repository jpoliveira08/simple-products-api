<?php

declare(strict_types=1);

namespace Backend\Api\Helpers;

class ResponseHelper
{
    public function buildReponse($response)
    {
        if (!$response) {
            return [
                'message' => GenericConstantsHelper::ERROR_MSG_EMPTY_RESPONSE
            ];
        }

        return [
            'message' => $response
        ];
    }
}