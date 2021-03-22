<?php 

namespace Core;

use Core\Component\Http\Response;
use Core\Component\Config\ConfigLoader;
use Core\Component\Routing\RouteException;
use Core\Component\Controller\ControllerException;
use Core\Component\Http\Interfaces\RequestInterface;
use Core\Component\Controller\ArgumentResolverInterface;
use Core\Component\Controller\ControllerResolverInterface;
use Core\Component\Routing\{RouteResolverInterface, RouterInterface};


class App 
{

    private $request;
    private $routeResolver;
    private $controllerResolver;
    private $argumentResolver;
    private $router;
    private $configLoader;

    public function __construct(
        RequestInterface $request,
        RouteResolverInterface $routeResolver,
        ControllerResolverInterface $controllerResolver,
        ArgumentResolverInterface $argumentResolver, 
        RouterInterface $router,
        ConfigLoader $configLoader
    )
    {
        $this->request = $request;
        $this->routeResolver = $routeResolver;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
        $this->router = $router;
        $this->configLoader = $configLoader;
    }

    public function run()
    {   

        try{

            $router = $this->router;
            require_once $this->configLoader->routes('path');

            $route = $this->routeResolver->resolve($this->request,$router);

            $controller = $this->controllerResolver->resolve($route);

            $arguments = $this->argumentResolver->resolve($controller,$route);

            call_user_func_array($controller,$arguments);

        }
        catch(\Exception $e) {

            $message = $e->getMessage();

            $projectDir = str_replace('/public','',$_SERVER['DOCUMENT_ROOT']);
            $errorViews = $projectDir . '/core/views/errors/' . $e->getCode() . '.php';

            if (file_exists($errorViews)) {
                ob_start();
                    include_once $errorViews;
                    $message = ob_get_contents();
                    ob_clean();
                ob_flush();
            }

            print(new Response($message,$e->getCode()));

        }

    }


}


