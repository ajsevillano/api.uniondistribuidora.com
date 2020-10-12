<?php namespace APP\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use APP\models\products as productsRequest;

class products
{
    public function getAll(Request $request, Response $response)
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
        $resultQueryId = $objetProductId->getId($arg['id']);

        //Check if the response from the DB is empty and return an error message in this case.
        if (empty($resultQueryId)) {
            $emptyResult = json_encode(
                [
                    'status' => 'error',
                    'Message' =>
                        'The item ' .
                        $arg['id'] .
                        ' you requested do not exist',
                ],
                JSON_PRETTY_PRINT
            );
            $response->getBody()->write($emptyResult);
            return $response->withHeader('Content-Type', 'application/json');
        }
        
        //Return the Product ID in an json object
        $encodeResult = json_encode($resultQueryId, JSON_PRETTY_PRINT);
        $response->getBody()->write($encodeResult);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function CreateNewProduct(Response $response, $arg)
    {
        $postTest = 'The POST method works!';
        $encodeResult = json_encode($postTest, JSON_PRETTY_PRINT);
        $response->getBody()->write($encodeResult);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
