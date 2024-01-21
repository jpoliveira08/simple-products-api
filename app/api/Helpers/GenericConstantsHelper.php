<?php

declare(strict_types=1);

namespace Backend\Api\Helpers;

abstract class GenericConstantsHelper
{
    /* REQUESTS */
    public const REQUEST_TYPE = ['GET', 'POST', 'DELETE', 'PUT'];
    public const GET = ['PRODUCTS', 'CATEGORIES'];
    public const POST = ['PRODUCTS', 'CATEGORIES'];
    public const DELETE = ['PRODUCTS', 'CATEGORIES'];
    public const PUT = ['PRODUCTS', 'CATEGORIES'];
    

    /* ERRORS */
    public const ERROR_MSG_TYPE_ROUTE = 'Route not allowed!';
    public const ERROR_MSG_ACTION_NOT_FOUND = 'Action not found!';
    public const ERROR_MSG_GENERIC = 'An error occurred in the request!';
    public const ERROR_MSG_EMPTY_RESPONSE = 'No records found!';
    public const ERROR_MSG_NO_RECORDS_AFFECTED = 'No records affected';
    public const ERROR_MSG_EMPTY_TOKEN = 'A Token is required!';
    public const ERROR_MSG_UNAUTHORIZED_TOKEN = 'Unauthorized Token!';
    public const ERROR_MSG_EMPTY_JSON = 'The request body cannot be empty!';

    /* SUCCESS */
    public const MSG_DELETE_SUCCESS = 'Record deleted successfully!';
    public const MSG_UPDATE_SUCCESS = 'Record updated successfully!';

    /* RESOURCES */
    public const ERROR_MSG_REQUIRED_ID = 'An id is required!!';
}