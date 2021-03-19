<?php 

namespace Core\Component\Routing;

use Core\Component\Http\Interfaces\RequestInterface;
use Core\Component\Routing\RouteCollection;
use Core\Component\Routing\Route;

interface RouteResolverInterface
{
    public function resolve(RequestInterface $request,RouteCollection $routes): ?Route;
}
