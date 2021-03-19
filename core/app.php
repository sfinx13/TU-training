<?php 

namespace Core;
use Core\Component\Http\Interfaces\RequestInterface;
use Core\Component\Resolver\ControllerResolver;
use Core\Component\Resolver\RouteResolverInterface;

class App 
{

    private $request;
    private $routeResolver;
    private $controllerResolver;

    public function __construct(RequestInterface $request,RouteResolverInterface $routeResolver,ControllerResolver $controllerResolver)
    {
        $this->request = $request;
        $this->routeResolver = $routeResolver;
        $this->controllerResolver = $controllerResolver;
    }

    public function run()
    {   

        try{

            $route = $this->routeResolver->resolve($this->request);

            $controller = $this->controllerResolver->resolve($route);

            call_user_func($controller);

        }
        catch(\Exception $e) {
            header('HTTP/1.0 404 Not Found');
            print_r('Not found 404');
            exit;
        }
       
    }


}


