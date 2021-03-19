<?php

namespace Core\Component\Controller;

use Core\Component\Routing\Route;
use Core\Exception\ControllerException;

class ControllerResolver
{

    public function resolve(Route $route): array
    {   
        
        $controllerStringParse = explode('::',$route->getController());

        if (count($controllerStringParse) === 0) {
            throw new ControllerException('Cannot set controller');
        }

        $class = $controllerStringParse[0];
        $method = $controllerStringParse[1];

        if (!class_exists($class)) {
            throw new ControllerException('"' . $class . '" class not found');
        }

        if (!method_exists(new $class,$method)) {
            throw new ControllerException('method "' . $method . '" not found in "' . $class .'"');
        }

        return [
            $class,
            $method
        ];
        
    }


}