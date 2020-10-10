<?php namespace APP\core;

require __DIR__ . '/../../vendor/autoload.php';
use APP\core\router as router;

$runAPP = new router();
$runAPP->loadApp();
