<?php namespace APP\core;

use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

class router
{
  private $app;
  public function loadApp()
  {
    //Get the slim objet
    $this->app = AppFactory::create();
    //Return a more readable error.
    $this->app->addErrorMiddleware(true, true, true);

    //Root (Homepage) route - Static view using Php view library.
    $this->app->get('/', '\APP\controllers\home:index');

    //Products GET routes
    $this->app->get('/products', '\APP\controllers\products:index');
    $this->app->get('/products/{id:[0-9]+}', '\APP\controllers\products:getID');

    return $this->app->run();
  }
}