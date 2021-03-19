<?php 

namespace Core\Component\Routing;

use Core\Component\Http\Interfaces\RequestInterface;
use Core\Component\Routing\Route;
use Core\Component\Routing\RouteCollection;

class RouteResolver implements RouteResolverInterface
{

    public function resolve(RequestInterface $request,RouteCollection $routes): ?Route
    {   

        $route = null;

        foreach ($routes->getAll() as $r) {
            if ($r->getUri() == $request->getUri()) {
                $route = $r;
            }
        }

        if($route != null) {
            return $route;
        }
        else if($route === null && $request->getUri() == "/") {
            return new Route("default","/","Core\Component\Controller\DefaultController::index");
        }

        throw new \Exception('Route Not found');

    }

    

}
