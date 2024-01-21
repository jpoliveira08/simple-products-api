<?php

declare(strict_types=1);

namespace Backend\Api\Models;

use Backend\Api\Config;
use PDO;

abstract class ConnectionCreator
{
    /**
     * Get the PDO database connection
     *
     * @return PDO
     */
    public static function createConnection(): PDO
    {
        $dsn = 'mysql:host=' . Config::DB_HOST . ';port=' . Config::DB_PORT . ';dbname=' . Config::DB_NAME;

        $connection = new PDO (
            $dsn,
            Config::DB_USER,
            Config::DB_PASSWORD
        );

        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $connection;
    }
}
