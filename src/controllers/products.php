<?php namespace APP\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class products
{
    public function index(Request $request, Response $response, $arg)
    {
        $route = $request->getUri()->getPath();
        $home = json_encode(['Controller' => $route], JSON_PRETTY_PRINT);
        $response->getBody()->write($home);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getID($request, $response, $arg)
    {
        $payload = json_encode(['id' => $arg['id']], JSON_PRETTY_PRINT);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
