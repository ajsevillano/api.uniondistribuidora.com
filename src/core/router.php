<?php namespace APP\core;

use Slim\Factory\AppFactory;

class router
{
  private $app;
  public function loadApp()
  {
    //Get the slim objet
    $this->app = AppFactory::create();

    //Root (Homepage) route
    $this->app->get('/', '\APP\controllers\home:index');

    //Products GET routes
    $this->app->get('/products', '\APP\controllers\products:index');
    $this->app->get('/products/{id}', '\APP\controllers\products:getID');

    return $this->app->run();
  }
}