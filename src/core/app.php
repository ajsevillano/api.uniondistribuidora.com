<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/../../vendor/autoload.php';

$app = AppFactory::create();

require __DIR__ . '/router.php';

$app->run();