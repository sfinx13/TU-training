<?php 

namespace Core\Component\Resolver;

use Core\Component\Http\Interfaces\RequestInterface;

class RouteResolver implements RouteResolverInterface
{

    public function resolve(RequestInterface $request): array
    {   
        $routes = [];
        $routesFile = __DIR__ . '/../../../config/routes.php';
        
        if (file_exists($routesFile)) {
            $routes = include_once $routesFile;
        }
        
        if (isset($routes[$request->getUri()])) {
            return $routes[$request->getUri()];
        }

        if ($request->getUri() == "/") {
            return [
                    "name" => "default",
                    "controller" => "Core\Controller\DefaultController::index"
            ];
        }

        throw new \Exception('Route Not found');
    }
    

}
