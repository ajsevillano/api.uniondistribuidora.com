<?php namespace APP\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use APP\models\products as productsRequest;

class products
{
    public function index(Request $request, Response $response)
    {
        $objetProductsList = new productsRequest();
        $resultQueryAll = $objetProductsList->getAll();

        //Return all the products in an json object
        $encodeResult = json_encode($resultQueryAll, JSON_PRETTY_PRINT);
        $response->getBody()->write($encodeResult);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getID(Request $request, Response $response, $arg)
    {
        $objetProductId = new productsRequest();
        $resultQueryId = $objetProductId->getId($arg);

        //Return the Product ID in an json object
        $encodeResult = json_encode($resultQueryId, JSON_PRETTY_PRINT);
        $response->getBody()->write($encodeResult);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
