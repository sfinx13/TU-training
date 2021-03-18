<?php 


require_once __DIR__ . '/../vendor/autoload.php';

use Core\Component\Http\Factory\RequestFactory;
use Core\App;

$request = RequestFactory::create();

$app = new App($request);
$app->run();


