<?php

//Root (Homepage) route
$app->get('/', '\APP\controllers\home:index');

//Products GET routes
$app->get('/products', '\APP\controllers\products:index');
$app->get('/products/{id}', '\APP\controllers\products:getID');
