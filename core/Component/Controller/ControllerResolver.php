<?php

namespace Core\Component\Controller;

use Core\Component\Routing\Route;
use Core\Component\Controller\ControllerException;

class ControllerResolver implements ControllerResolverInterface
{

    public function resolve(Route $route): callable
    {

        if ($route->getCallback() instanceof \Closure) {
            return $route->getCallback();
        }

        $controllerStringParse = explode('::', $route->getCallback());

        if (count($controllerStringParse) === 0) {
            throw new ControllerCannotSetException('Cannot set controller');
        }

        $class = $controllerStringParse[0];
        $method = $controllerStringParse[1];

        if (!class_exists($class)) {
            throw new ControllerClassNotFoundException('"' . $class . '" class not found');
        }

        if (!method_exists(new $class, $method)) {
            throw new ControllerMethodNotFoundException('method "' . $method . '" not found in "' . $class . '"');
        }

        return [new $class, $method];

    }



}