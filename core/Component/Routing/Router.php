<?php

namespace Core\Component\Routing;

use Core\Component\Http\Interfaces\RequestInterface;

class Router implements RouterInterface
{

    private $routes = [];

    public function add(string $name, string $uri, callable $callback, array $regex = [], array $params = []): Route
    {
        $route =  new Route($name,$uri,$callback, $regex, $params);
        $this->routes[$route->getName()] = $route;
        return $route;
    }

    public function remove(string $name): void
    {
        if (isset($this->routes[$name])) {
            unset($this->routes[$name]);
        }
    }

    public function search(string $name): ?Route
    {
        if(!isset($this->routes[$name])) {
            return null;
        }
        return $this->routes[$name];
    }

    public function match(RequestInterface $request): ?Route
    {

        $routeRequested = null;

        foreach ($this->routes as $route) {
            if (null !== $compareResult = $this->uriAndRouteCompare($request->getUri(),$route)) {
               $routeRequested = $compareResult;
            }
        }

        if($routeRequested !== null) {
            $this->determineRouteParams($request->getUri(),$routeRequested);
        }

        return $routeRequested;

    }


    private function uriAndRouteCompare($uri,Route $route): ?Route
    {
        $routeRequested = null;

        $routeUri = $route->getUri();
        if (count($route->getRegex()) > 0) {
            foreach ($route->getRegex() as $keyParams => $param) {
                $routeUri = str_replace('{' . $keyParams . '}','(' . $param. ')',$routeUri);
            }
        }

        if (preg_match('#{([a-zA-Z0-9]{1,})}#',$routeUri)) {
            $routeUri = preg_replace('#{([a-zA-Z0-9]{1,})}#','([a-zA-Z0-9]){1,}',$routeUri);
        }

        $routeUri = str_replace('/','\/',$routeUri);

        if (preg_match('#^' . $routeUri . '$#',$uri)) {
            $routeRequested = $route;
        };

        return $routeRequested;
    }


    private function determineRouteParams($uri,Route $route): void
    {
        $params = [];
        $uriExplode = explode('/',$uri);
        $uriExplode = array_filter($uriExplode);

        $routeUriExplode = explode('/',$route->getUri());
        $routeUriExplode = array_filter($routeUriExplode);

        foreach ($routeUriExplode as $key => $item) {
            if (preg_match('#{([a-zA-Z0-9]{1,})}#',$item) && isset($uriExplode[$key])) {
                $item = str_replace('{','',$item);
                $item = str_replace('}','',$item);
                $params[$item] = $uriExplode[$key];
            }
        }

        $route->setParams($params);
    }


    public function getAllRoutes(): array
    {
        return $this->routes;
    }


}