<?php 

namespace Core\Component\Controller;

use Core\Component\Routing\Route;

interface ArgumentResolverInterface
{
    public function resolve(callable $controller,Route $route): array;
}