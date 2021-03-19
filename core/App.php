<?php 

namespace Core;
use Core\Component\Http\Interfaces\RequestInterface;
use Core\Component\Controller\ControllerResolver;
use Core\Component\Routing\RouteResolverInterface;
use Core\Component\Routing\RouteCollection;

class App 
{

    private $request;
    private $routeResolver;
    private $controllerResolver;
    private $routes;

    public function __construct(RequestInterface $request,RouteResolverInterface $routeResolver,ControllerResolver $controllerResolver,RouteCollection $routes)
    {
        $this->request = $request;
        $this->routeResolver = $routeResolver;
        $this->controllerResolver = $controllerResolver;
        $this->routes = $routes;
    }

    public function run()
    {   

        try{

            $routes = $this->routes;
            require_once __DIR__ . '/../config/routes.php';
              
            $route = $this->routeResolver->resolve($this->request,$routes);

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


