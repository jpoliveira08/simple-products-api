<?php

namespace Backend\Api\Interfaces;

interface ProductRepositoryInterface
{
    public function allProducts();
    public function productById($id);
    public function deleteProduct($id);
    public function createProduct($product);
    public function updateProduct($id, $newData);
}