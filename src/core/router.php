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

    //GET Routes
    $this->app->get('/products', '\APP\controllers\products:getAll');
    $this->app->get('/products/{id}', '\APP\controllers\products:getID');
    $this->app->get('/customers', '\APP\controllers\customers:getAll');
    $this->app->get('/customers/{id}', '\APP\controllers\customers:getID');

    //POST Routes
    $this->app->post('/products', '\APP\controllers\products:CreateNewProduct');
    $this->app->post('/customers', '\APP\controllers\customers:CreateNewCustomer');
    $this->app->post('/img', '\APP\controllers\uploadImage:getImage');

    //PUT Routes
    $this->app->put('/products', '\APP\controllers\products:UpdateProduct');
    $this->app->put('/customers', '\APP\controllers\customers:UpdateCustomer');

    return $this->app->run();
  }
}