<?php 

namespace Core\Component\Routing;

use Core\Component\Routing\Route;

class RouteCollection
{

    private $routes = [];

    public function addRoute(Route $route)
    {
        $this->routes[$route->getName()] = $route;
    }

    public function addRouteDirectly(string $name,string $uri, string $controller) : void
    {
        $route = new Route($name,$uri,$controller);
        $this->routes[$name] = $route;
    }

    public function getAll(): array
    {
        return $this->routes;
    }
    

}