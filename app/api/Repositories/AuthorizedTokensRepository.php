<?php

declare(strict_types=1);

namespace Backend\Api\Repositories;

use Backend\Api\Helpers\GenericConstantsHelper;
use Backend\Api\Models\ConnectionCreator;
use InvalidArgumentException;
use PDO;

class AuthorizedTokensRepository
{
    private PDO $dbConnection;
    public const TABLE = "authorized_tokens";

    public function __construct()
    {
        $this->dbConnection = ConnectionCreator::createConnection();
    }

    public function tokenValidator($authorizationRequestField)
    {
        if (!$authorizationRequestField) {
            throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_EMPTY_TOKEN);
        }

        $token = str_replace([' ', 'Bearer'], '', $authorizationRequestField);

        if ($this->searchToken($token) !== 1) {
            header('HTTP/1.1 401 Unauthorized');
            throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_UNAUTHORIZED_TOKEN);
        }
    }

    private function searchToken(string $token) {
        $query = 'SELECT id 
            FROM ' . self::TABLE . ' 
            WHERE token = :token 
            AND status = :status';
        $stmt = $this->dbConnection->prepare($query);

        $stmt->bindValue(':token', $token);
        $stmt->bindValue(':status', 'Y');
        $stmt->execute();

        return $stmt->rowCount();
    }
}
