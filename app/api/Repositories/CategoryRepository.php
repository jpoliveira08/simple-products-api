<?php

declare(strict_types=1);

namespace Backend\Api\Repositories;

use Backend\Api\Helpers\GenericConstantsHelper;
use Backend\Api\Models\ConnectionCreator;
use PDO;

class CategoryRepository
{
    private PDO $dbConnection;
    public const TABLE = "categories";

    public function __construct()
    {
        $this->dbConnection = ConnectionCreator::createConnection();
    }

    public function allCategories()
    {
        $query = 'SELECT * FROM ' . self::TABLE;
        $stmt = $this->dbConnection->query($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function categoryById($id)
    {
        $query = 'SELECT * FROM ' . self::TABLE . ' 
        WHERE id = :id';
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteCategory($id)
    {
        $query = 'DELETE FROM ' . self::TABLE . ' WHERE id = :id';
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->rowCount() > 0 ? GenericConstantsHelper::MSG_DELETE_SUCCESS : false;
    }
}