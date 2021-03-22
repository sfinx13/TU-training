<?php 

namespace Core\Component\Routing;

use Core\Component\Http\Interfaces\RequestInterface;

interface RouteResolverInterface
{
    public function resolve(RequestInterface $request,RouterInterface $routes): ?Route;
}
