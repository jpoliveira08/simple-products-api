<?php

declare(strict_types=1);

namespace Backend\Api\Controllers;

use Backend\Api\Helpers\GenericConstantsHelper;
use Backend\Api\Helpers\JsonHelper;
use Backend\Api\Repositories\AuthorizedTokensRepository;
use Backend\Api\Services\CategoryService;
use Backend\Api\Services\ProductService;
use InvalidArgumentException;

class Controller
{
    private $request;
    private $requestData = [];
    private AuthorizedTokensRepository $AuthorizedTokensRepository;

    public function __construct($request)
    {
        $this->request = $request;
        $this->AuthorizedTokensRepository = new AuthorizedTokensRepository();
    }

    public function handleRequest()
    {
        $response = json_encode(GenericConstantsHelper::ERROR_MSG_TYPE_ROUTE);
        if (in_array($this->request['method'], GenericConstantsHelper::REQUEST_TYPE, true)) {
            $response = $this->redirectRequest();
        }

        return $response;
    }

    private function redirectRequest()
    {
        $storeData = ['POST', 'PUT'];

        if (in_array($this->request['method'], $storeData)) {
            $this->requestData = JsonHelper::handleRequestBodyJson();
        }

        $this->AuthorizedTokensRepository->tokenValidator(
            getallheaders()['Authorization']
        );

        $method = $this->request['method'];

        return $this->$method();
    }

    private function get()
    {
        $response = json_encode(GenericConstantsHelper::ERROR_MSG_TYPE_ROUTE);

        if (in_array($this->request['route'], GenericConstantsHelper::GET, true)) {
            switch ($this->request['route']) {
                case 'PRODUCTS':
                    $productService = new ProductService($this->request);
                    $response = $productService->getValidator();
                    break;
                case 'CATEGORIES':
                    $categoryService = new CategoryService($this->request);
                    $response = $categoryService->getValidator();
                    break;
                default:
                    throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_ACTION_NOT_FOUND);
            }
        }

        return $response;
    }

    private function delete()
    {
        $response = json_encode(GenericConstantsHelper::ERROR_MSG_TYPE_ROUTE);

        if (in_array($this->request['route'], GenericConstantsHelper::DELETE, true)) {
            switch ($this->request['route']) {
                case 'PRODUCTS':
                    $productService = new ProductService($this->request);
                    $response = $productService->deleteValidator();
                    break;
                case 'CATEGORIES':
                    $categoryService = new CategoryService($this->request);
                    $response = $categoryService->deleteValidator();
                    break;
                default:
                    throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_ACTION_NOT_FOUND);
            }
        }

        return $response;
    }

    private function post()
    {
        $response = json_encode(GenericConstantsHelper::ERROR_MSG_TYPE_ROUTE);

        if (in_array($this->request['route'], GenericConstantsHelper::POST, true)) {
            switch ($this->request['route']) {
                case 'PRODUCTS':
                    $productService = new ProductService($this->request);
                    $productService->setDataRequestBody($this->requestData);
                    $response = $productService->postValidator();
                    header('HTTP/1.1 201 Created');
                    break;
                default:
                    throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_ACTION_NOT_FOUND);
            }
        }

        return $response;
    }

    private function put()
    {
        $response = json_encode(GenericConstantsHelper::ERROR_MSG_TYPE_ROUTE);

        if (in_array($this->request['route'], GenericConstantsHelper::PUT, true)) {
            switch ($this->request['route']) {
                case 'PRODUCTS':
                    $productService = new ProductService($this->request);
                    $productService->setDataRequestBody($this->requestData);
                    $response = $productService->putValidator();
                    break;
                default:
                    throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_ACTION_NOT_FOUND);
            }
        }

        return $response;
    }
}