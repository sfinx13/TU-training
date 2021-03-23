<?php 

namespace Core;

use Core\Component\EventEmitter\EventEmitter;
use Core\Component\Http\Factory\RequestFactory;
use Core\Component\Controller\ControllerResolver;
use Core\Component\Routing\{Router,RouteResolver};
use Core\Component\Controller\ArgumentResolver;
use Core\Component\Config\ConfigLoader;
use Core\App;

class AppFactory
{

    private static $configLoaderInstance;
    private static $dbInstance;

    public function create()
    {

        return new App(
            RequestFactory::create(),
            new RouteResolver,
            new ControllerResolver,
            new ArgumentResolver,
            new Router,
            new EventEmitter,
            $this->configLoaderInstance(),
        );
    }

    public function configLoaderInstance()
    {
        
        if (self::$configLoaderInstance === null) {
            
            $projectDir = str_replace('/public','',$_SERVER["DOCUMENT_ROOT"]);
            $config = include_once $projectDir . '/config/app.php'; 
            
            self::$configLoaderInstance = new ConfigLoader($config);    
        }

        return self::$configLoaderInstance;

    }



}