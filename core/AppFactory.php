<?php 

namespace Core;

use Core\Component\Http\Factory\RequestFactory;
use Core\Component\Controller\ControllerResolver;
use Core\Component\Routing\{
    RouteCollection,
    RouteResolver
};
use Core\App;
use Core\Component\Controller\ArgumentResolver;

class AppFactory
{

    private static $routesInstance;

    public function create()
    {
        return new App(
            RequestFactory::create(),
            new RouteResolver,
            new ControllerResolver,
            new ArgumentResolver,
            $this->routeInstance()
        );
    }


    private function routeInstance() {
        
        if ($this->routeInstance == null) {
            $this->routeInstance = new RouteCollection;
        }

        return $this->routeInstance;
    }


}