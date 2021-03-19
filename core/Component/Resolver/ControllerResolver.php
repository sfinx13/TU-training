<?php

namespace Core\Component\Resolver;

class ControllerResolver
{

    public function resolve(array $route): array
    {   
        
        $controllerStringParse = explode('::',$route["controller"]);
        
        if (count($controllerStringParse) > 1) {
            if (class_exists($controllerStringParse[0]) && method_exists(new $controllerStringParse[0],$controllerStringParse[1])) {
                return [new $controllerStringParse[0],$controllerStringParse[1]];
            }
        }

        throw new \Exception('Controller Not found');
    }


}