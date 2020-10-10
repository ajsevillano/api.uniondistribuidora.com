<?php namespace APP\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use APP\models\products as productsRequest;

class products
{
    public function index(Request $request, Response $response)
    {
        $objetProductsList = new productsRequest();
        $objetProductsList->getAll();

        $route = $request->getUri()->getPath();
        $home = json_encode(['Controller' => $route], JSON_PRETTY_PRINT);
        $response->getBody()->write($home);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getID(Request $request,Response $response, $arg)
    {
        $theID = json_encode(['id' => $arg['id']], JSON_PRETTY_PRINT);
        $response->getBody()->write($theID);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
