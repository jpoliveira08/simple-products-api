<?php

declare(strict_types=1);

namespace Backend\Api\Services;

use Backend\Api\Helpers\GenericConstantsHelper;
use Backend\Api\Helpers\ResponseHelper;
use Backend\Api\Repositories\ProductRepository;
use InvalidArgumentException;

class ProductService
{
    public const GET_RESOURCES = ['list'];
    public const DELETE_RESOURCES = ['delete'];
    public const POST_RESOURCES = ['store'];
    public const PUT_RESOURCES = ['update'];
    private $data;
    private ProductRepository $productRepository;
    private ResponseHelper $responseHelper;
    private $requestBody = [];

    public function __construct($data = [])
    {
        $this->data = $data;
        $this->productRepository = new ProductRepository();
        $this->responseHelper = new ResponseHelper();
    }

    public function getValidator()
    {
        $response = null;
        $action = $this->data['action'];
        
        if (!in_array($action, self::GET_RESOURCES, true) || is_null($action)) {
            header('HTTP/1.1 404 Not found');
            throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_ACTION_NOT_FOUND);
        }
        
        $response = is_null($this->data['id']) ? $this->$action() : $this->getOneByKey();

        if(is_null($response)) {
            throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_GENERIC);
        }

        return $response;
    }

    public function deleteValidator()
    {
        $response = null;
        $action = $this->data['action'];
        
        if (!in_array($action, self::DELETE_RESOURCES, true) || is_null($action)) {
            header('HTTP/1.1 404 Not found');
            throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_ACTION_NOT_FOUND);
        }
        
        if ($this->data['id'] <= 0) {
            header('HTTP/1.1 422 Unprocessable Entity');
            throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_REQUIRED_ID);
        }

        $response = $this->$action();

        if(is_null($response)) {
            throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_GENERIC);
        }

        return $response;
    }

    public function postValidator()
    {
        $response = null;
        $action = $this->data['action'];
        
        if (!in_array($action, self::POST_RESOURCES, true) || is_null($action)) {
            header('HTTP/1.1 404 Not found');
            throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_ACTION_NOT_FOUND);
        }
        
        $response = $this->$action();

        if(is_null($response)) {
            throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_GENERIC);
        }

        return $response;
    }

    public function putValidator()
    {
        $response = null;
        $action = $this->data['action'];
        
        if (!in_array($action, self::PUT_RESOURCES, true) || is_null($action)) {
            throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_ACTION_NOT_FOUND);
        }
        
        if ($this->data['id'] <= 0) {
            throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_REQUIRED_ID);
        }

        $response = $this->$action();

        if(is_null($response)) {
            throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_GENERIC);
        }

        return $response;
    }

    public function setDataRequestBody($requestData)
    {
        $this->requestBody = $requestData;
    }

    private function getOneByKey()
    {
        return $this->responseHelper->buildReponse(
            $this->productRepository->productById($this->data['id'])
        );
    }

    private function list()
    {
        return $this->responseHelper->buildReponse(
            $this->productRepository->allProducts()
        );
    }

    private function delete()
    {
        return $this->responseHelper->buildReponse(
            $this->productRepository->deleteProduct($this->data['id'])
        );
    }

    private function store()
    {
        $name = $this->requestBody['name'];
        $sku = $this->requestBody['sku'];
        $price = $this->requestBody['price'];
        $description = $this->requestBody['description'];
        $amount = $this->requestBody['amount'];

        $product = [
            'name' => $name,
            'sku' => $sku,
            'price' => round($price, 2),
            'description' => $description,
            'amount' => $amount
        ];
        
        $this->validEmptyFields($product);

        return $this->responseHelper->buildReponse(
            $this->productRepository->createProduct($product)
        );
    }

    private function update()
    {
        $name = $this->requestBody['name'];
        $sku = $this->requestBody['sku'];
        $price = $this->requestBody['price'];
        $description = $this->requestBody['description'];
        $amount = $this->requestBody['amount'];

        $product = [
            'name' => $name,
            'sku' => $sku,
            'price' => round($price, 2),
            'description' => $description,
            'amount' => $amount,
        ];

        $this->validEmptyFields($product);

        if ($this->productRepository->updateProduct($this->data['id'], $product) <= 0) {
            throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_NO_RECORDS_AFFECTED);
        }

        return [
            'message' => GenericConstantsHelper::MSG_UPDATE_SUCCESS
        ];
    }

    private function validEmptyFields($products) {
        foreach ($products as $key => $value) {
            if ($key == 'description') {
                continue;
            }

            if (empty($value)) {
                throw new InvalidArgumentException('The field ' . $key . ' is required.');
            }
        }
    }
}
