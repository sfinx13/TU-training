<?php 

namespace Core\Component\Controller;

use QH\Routing\Route\Route;

interface ArgumentResolverInterface
{
    public function resolve(callable $controller,Route $route): array;
}