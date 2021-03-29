<?php 

namespace Core;

use Core\Component\EventEmitter\Event\{ArgumentEvent, ControllerEvent, RequestEvent, ResponseEvent, RouteEvent};
use Core\Component\EventEmitter\EventEmitterInterface;
use Core\Component\Http\ErrorViewHandler;
use Core\Component\Http\Response;
use Core\Component\Config\ConfigLoader;
use Core\Component\Controller\ControllerException;
use Psr\Http\Message\RequestInterface;
use Core\Component\Controller\ArgumentResolverInterface;
use Core\Component\Controller\ControllerResolverInterface;
use QH\Routing\Route\RouteException;
use QH\Routing\Router\RouterInterface;
use QH\Routing\Route\RouteResolverInterface;


class App 
{

    private $request;
    private $routeResolver;
    private $controllerResolver;
    private $argumentResolver;
    private $router;
    private $eventEmitter;
    private $configLoader;

    public function __construct(
        RequestInterface $request,
        RouteResolverInterface $routeResolver,
        ControllerResolverInterface $controllerResolver,
        ArgumentResolverInterface $argumentResolver, 
        RouterInterface $router,
        EventEmitterInterface $eventEmitter,
        ConfigLoader $configLoader
    )
    {
        $this->request = $request;
        $this->routeResolver = $routeResolver;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
        $this->router = $router;
        $this->eventEmitter = $eventEmitter;
        $this->configLoader = $configLoader;
    }

    public function run()
    {
        try{

            $config = require_once PROJECT_DIR . '/config/app.php';
            $this->configLoader->load($config);

            $eventEmitter = $this->eventEmitter;

            require_once $this->configLoader->events('path');
            $eventEmitter->emit('core.request',new RequestEvent($this->request));

            $router = $this->router;
            require_once $this->configLoader->routes('path');

            $route = $this->routeResolver->resolve($this->request,$router);

            $eventEmitter->emit('core.route',new RouteEvent($route));

            $controller = $this->controllerResolver->resolve($route);
            $eventEmitter->emit('core.controller',new ControllerEvent($controller));

            $arguments = $this->argumentResolver->resolve($controller,$route);
            $eventEmitter->emit('core.argument',new ArgumentEvent($arguments));

            call_user_func_array($controller,$arguments);

        }
        catch (RouteException $e) {
            if($this->request->getUri() == "/") {
                call_user_func([new \Core\Component\Controller\DefaultController,'index']);
                return;
            }
            $message = ErrorViewHandler::show($e);
            print(new Response($message,$e->getCode()));
        }
        catch(\Exception $e) {
            $message = ErrorViewHandler::show($e);
            print(new Response($message,$e->getCode()));
        }


    }


}


