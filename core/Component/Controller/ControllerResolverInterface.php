<?php

namespace Core\Component\Controller;

use Core\Component\Routing\Route;

interface ControllerResolverInterface
{
    public function resolve(Route $route): callable;
}