<?php


$router->add('home','/','App\Controller\HomeController::index');

$router->add('about','/about','App\Controller\AboutController::index');

$router->add('team','/teams','App\Controller\TeamsController::index');

$router->add('contact','/contact','App\Controller\ContactController::index');

