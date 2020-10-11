<?php namespace APP\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;


class home
{
    public function index($request, $response, $args)
    {
    $renderer = new PhpRenderer( __DIR__ .'/../views/');
    return $renderer->render($response, "home.html", $args);
    }

}
