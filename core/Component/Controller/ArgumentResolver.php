<?php 

namespace Core\Component\Controller;

use Core\Component\Http\Request;
use Core\Component\Routing\Route;
use Core\Component\Container\Container;

class ArgumentResolver implements ArgumentResolverInterface
{

    public function resolve(callable $callback, Route $route): array
    {
        $arg = [];
        $arg = array_merge($arg,$route->getParams());

        if(!$callback instanceof \Closure) {
            $this->controllerReflection($callback, $arg);
        }

        return $arg;
    }


    private function controllerReflection(callable $callback, array &$arg)
    {
        $this->methodRelection($callback, $arg);
    }


    private function methodRelection(callable $callback, array &$arg)
    {
        try {
            $reflexion = new \ReflectionMethod($callback[0], $callback[1]);
        }
        catch(\ReflectionException $e) {
            throw new \ReflectionException($e->getMessage());
        }

        if (is_array($reflexion->getParameters()) && count($reflexion->getParameters()) > 0) {

            foreach ($reflexion->getParameters() as $param) {
                $class = $param->getType()->getName();
                if(class_exists($class)) {

                    $class = new $class;
                    if ($class instanceof Request) {
                        $container = new Container;
                        $class = $container->get('core.request');
                    }
                    array_push($arg,$class);
                }
            }
        }

    }


}