<?php 

require_once __DIR__ . '/../vendor/autoload.php';

$app = (new Core\AppFactory)->create();
$app->run();


