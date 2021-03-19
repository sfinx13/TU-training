<?php

namespace Core\Component\Controller;

use Core\Component\Routing\Route;

class ControllerResolver
{

    public function resolve(Route $route): array
    {   
        
        $controllerStringParse = explode('::',$route->getController());
        
        if (count($controllerStringParse) > 1) {
            if (class_exists($controllerStringParse[0]) && method_exists(new $controllerStringParse[0],$controllerStringParse[1])) {
                return [new $controllerStringParse[0],$controllerStringParse[1]];
            }
        }

        throw new \Exception('Controller Not found');
    }


}