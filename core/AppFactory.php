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
use Core\Component\Config\ConfigLoader;

class AppFactory
{

    private static $routesInstance;

    private static $configLoaderInstance;

    public function create()
    {

        $this->configLoaderInstance();

        return new App(
            RequestFactory::create(),
            new RouteResolver,
            new ControllerResolver,
            new ArgumentResolver,
            $this->routeInstance(),
            $this->configLoaderInstance(),
        );
    }


    public function routeInstance() {
        
        if (self::$routesInstance == null) {
            self::$routesInstance = new RouteCollection;
        }

        return self::$routesInstance;
    }


    public function configLoaderInstance()
    {
        
        if (self::$configLoaderInstance == null) {
            
            $projectDir = str_replace('/public','',$_SERVER["DOCUMENT_ROOT"]);
            $config = include_once $projectDir . '/config/app.php'; 
            
            self::$configLoaderInstance = new ConfigLoader($config);    
        }

        return self::$configLoaderInstance;

    }


}