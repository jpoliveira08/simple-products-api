<?php

declare(strict_types=1);

namespace Backend\Api\Repositories;

use Backend\Api\Helpers\GenericConstantsHelper;
use Backend\Api\Interfaces\ProductRepositoryInterface;
use Backend\Api\Models\ConnectionCreator;
use PDO;

class ProductRepository implements ProductRepositoryInterface
{
    private PDO $dbConnection;
    public const TABLE = "products";

    public function __construct()
    {
        $this->dbConnection = ConnectionCreator::createConnection();
    }

    public function allProducts()
    {
        $query = 'SELECT * FROM ' . self::TABLE;
        $stmt = $this->dbConnection->query($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function productById($id)
    {
        $query = 'SELECT * FROM ' . self::TABLE . ' 
            WHERE id = :id';
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteProduct($id)
    {
        $query = 'DELETE FROM ' . self::TABLE . ' WHERE id = :id';
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->rowCount() > 0 ? GenericConstantsHelper::MSG_DELETE_SUCCESS : false;
    }

    public function createProduct($product)
    {
        $query = 'INSERT INTO ' . self::TABLE . ' (name, sku, price, description, amount) 
            VALUES (:name, :sku, :price, :description, :amount)';
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindValue(':name', $product['name']);
        $stmt->bindValue(':sku', $product['sku']);
        $stmt->bindValue(':price', $product['price']);
        $stmt->bindValue(':description', $product['description']);
        $stmt->bindValue(':amount', $product['amount']);
        $stmt->execute();

        return $stmt->rowCount() > 0 ? ['id' => $this->dbConnection->lastInsertId()] : false;
    }

    public function updateProduct($id, $newData)
    {
        $query = 'UPDATE ' . self::TABLE . ' 
            SET name = :name, 
            sku = :sku, 
            price = :price, 
            description = :description, 
            amount = :amount
            WHERE id = :id';

        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindValue(':name', $newData['name']);
        $stmt->bindValue(':sku', $newData['sku']);
        $stmt->bindValue(':price', $newData['price']);
        $stmt->bindValue(':description', $newData['description']);
        $stmt->bindValue(':amount', $newData['amount']);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->rowCount();
    }
}