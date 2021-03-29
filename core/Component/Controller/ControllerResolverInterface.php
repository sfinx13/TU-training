<?php

namespace Core\Component\Controller;

use QH\Routing\Route\Route;

interface ControllerResolverInterface
{
    public function resolve(Route $route): callable;
}