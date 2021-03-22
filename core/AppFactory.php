<?php 

namespace Core;

use Core\Component\Http\Factory\RequestFactory;
use Core\Component\Controller\ControllerResolver;
use Core\Component\ORM\PDOStorage;
use Core\Component\Routing\{
    RouteCollection,
    RouteResolver
};
use Core\App;
use Core\Component\Controller\ArgumentResolver;
use Core\Component\Config\ConfigLoader;
use Core\Component\Routing\Router;

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


    public function dbInstance()
    {
        if (self::$dbInstance === null) {

            $configLoader = $this->configLoaderInstance();
            $dbConfig = $configLoader->get('db');
            extract($dbConfig);

            self::$dbInstance = new PDOStorage($dsn,$username,$password,$options);
        }

        return self::$dbInstance;

    }


}