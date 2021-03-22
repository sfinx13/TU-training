<?php 

namespace Core\Component\Routing;

use Core\Component\Http\Interfaces\RequestInterface;
use Core\Component\Routing\Route;
use Core\Component\Routing\RouteCollection;
use Core\Component\Routing\RouteException;

class RouteResolver implements RouteResolverInterface
{

    public function resolve(RequestInterface $request,RouterInterface $router): ?Route
    {   

        $routeRequested = $router->match($request);

        if ($routeRequested === null && $request->getUri() == "/") {
            return new Route("default","/","Core\Component\Controller\DefaultController::index");
        }

        if ($routeRequested === null) {
            throw new RouteException('Route Not found');
        }

        return $routeRequested;

    }

    

}
