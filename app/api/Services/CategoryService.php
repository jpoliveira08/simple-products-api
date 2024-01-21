<?php

declare(strict_types=1);

namespace Backend\Api\Services;

use Backend\Api\Helpers\GenericConstantsHelper;
use Backend\Api\Helpers\ResponseHelper;
use Backend\Api\Repositories\CategoryRepository;
use InvalidArgumentException;

class CategoryService
{
    public const GET_RESOURCES = ['list'];
    public const DELETE_RESOURCES = ['delete'];
    public const POST_RESOURCES = ['store'];
    public const PUT_RESOURCES = ['update'];
    private $data;
    private CategoryRepository $categoryRepository;
    private ResponseHelper $responseHelper;

    public function __construct($data = [])
    {
        $this->data = $data;
        $this->categoryRepository = new CategoryRepository();
        $this->responseHelper = new ResponseHelper();
    }

    public function getValidator()
    {
        $response = null;
        $action = $this->data['action'];
        
        $this->isActionValid($action, self::GET_RESOURCES);

        $response = is_null($this->data['id']) ? $this->$action() : $this->getOneByKey();

        $this->checkNullResponse($response);

        return $response;
    }

    public function deleteValidator()
    {
        $response = null;
        $action = $this->data['action'];
        
        $this->isActionValid($action, self::DELETE_RESOURCES);
        
        if ($this->data['id'] <= 0) {
            header('HTTP/1.1 422 Unprocessable Entity');
            throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_REQUIRED_ID);
        }

        $response = $this->$action();

        $this->checkNullResponse($response);

        return $response;
    }

    public function postValidator()
    {

    }

    public function putValidor()
    {

    }

    public function setDataRequestBody($requestData)
    {
        $this->requestBody = $requestData;
    }

    private function getOneByKey()
    {
        $categoryData = $this->categoryRepository->categoryById($this->data['id']);

        if (!$categoryData) {
            header('HTTP/1.1 404 Not found');
            throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_EMPTY_RESPONSE);
        }

        return ['message' => $categoryData];
    }

    private function list()
    {
        return $this->responseHelper->buildReponse(
            $this->categoryRepository->allCategories()
        );
    }

    private function delete()
    {
        $deleteResponse = $this->categoryRepository->deleteCategory($this->data['id']);

        if (!$deleteResponse) {
            header('HTTP/1.1 404 Not found');
            throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_EMPTY_RESPONSE);
        }

        return ['message' => $deleteResponse];
    }

    private function checkNullResponse($response)
    {
        if(is_null($response)) {
            header('HTTP/1.1 400');
            throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_GENERIC);
        }
    }

    private function isActionValid($action, $actions)
    {
        if (!in_array($action, $actions, true) || is_null($action)) {
            header('HTTP/1.1 404 Not found');
            throw new InvalidArgumentException(GenericConstantsHelper::ERROR_MSG_ACTION_NOT_FOUND);
        }
    }
}
