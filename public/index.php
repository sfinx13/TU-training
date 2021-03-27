<?php

define('PROJECT_DIR',dirname(__DIR__));

require_once __DIR__ . '/../vendor/autoload.php';

use Core\Component\Container\Container;
use Core\Component\Container\ContainerDefaultConfig;

$container = new Container(
    ContainerDefaultConfig::services(),
    ContainerDefaultConfig::mapping()
);

require_once PROJECT_DIR . '/config/container.php';

$app = $container->instanciate(Core\App::class);
$app->run();



