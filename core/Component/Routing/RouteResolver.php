<?php 

namespace Core\Component\Routing;

use Core\Component\Http\Interfaces\RequestInterface;
use Core\Component\Routing\Route;
use Core\Component\Routing\RouteCollection;
use Core\Exception\RouteException;

class RouteResolver implements RouteResolverInterface
{

    public function resolve(RequestInterface $request,RouteCollection $routes): ?Route
    {   

        $routeRequested = null;

        foreach ($routes->getAll() as $route) {
            if ($route->getUri() == $request->getUri()) {
                $routeRequested = $route;
            }
        }

        if ($routeRequested === null && $request->getUri() == "/") {
            return new Route("default","/","Core\Component\Controller\DefaultController::index");
        }

        if ($routeRequested === null) {
            throw new RouteException('Route Not found');
        }

        return $routeRequested;

    }

    

}
