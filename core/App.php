<?php 

namespace Core;

use Core\Component\Controller\ArgumentResolverInterface;
use Core\Component\Http\Interfaces\RequestInterface;
use Core\Component\Controller\ControllerResolverInterface;
use Core\Component\Routing\{RouteResolverInterface,RouteCollection};
use Core\Component\Controller\ControllerException;
use Core\Component\Http\Response;
use Core\Component\Routing\RouteException;


class App 
{

    private $request;
    private $routeResolver;
    private $controllerResolver;
    private $argumentResolver;
    private $routes;

    public function __construct(RequestInterface $request,RouteResolverInterface $routeResolver,ControllerResolverInterface $controllerResolver,ArgumentResolverInterface $argumentResolver, RouteCollection $routes)
    {
        $this->request = $request;
        $this->routeResolver = $routeResolver;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
        $this->routes = $routes;
    }

    public function run()
    {   

        try{

            $routes = $this->routes;
            require_once __DIR__ . '/../config/routes.php';
  
            $route = $this->routeResolver->resolve($this->request,$routes);

            $controller = $this->controllerResolver->resolve($route);

            $arguments = $this->argumentResolver->resolve($controller);

            call_user_func_array($controller,$arguments);

        }
        catch(\Exception $e) {
            printf(new Response($e->getMessage(),$e->getCode()));
        }
       
    }


}


