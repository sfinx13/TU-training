<?php 

namespace Core;

use Core\Component\Http\Factory\RequestFactory;
use Core\Component\Resolver\RouteResolver;
use Core\Component\Resolver\ControllerResolver;
use Core\App;

class AppFactory
{

    public function create()
    {
        return new App(
            RequestFactory::create(),
            new RouteResolver,
            new ControllerResolver,
        );
    }

}