<?php namespace APP\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class home
{
    public function index($request, $response, $arg)
    {
        $response->getBody()->write("home controller");
        return $response;
    }
}
