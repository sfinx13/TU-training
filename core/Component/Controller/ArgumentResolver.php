<?php 

namespace Core\Component\Controller;

use Core\Component\Http\Factory\RequestFactory;
use Core\Component\Http\Request;

class ArgumentResolver implements ArgumentResolverInterface
{

    public function resolve(array $controller): array
    {
        $arg = [];

        $reflexion = new \ReflectionMethod($controller[0],$controller[1]);

        if (is_array($reflexion->getParameters()) && count($reflexion->getParameters()) > 0) {

            foreach ($reflexion->getParameters() as $param) {

                $class = $param->getType()->getName();
                $class = new $class;
                
                if ($class instanceof Request) {
                    $class = RequestFactory::create();
                }
                
                array_push($arg,$class);
            
            }

        }
        
        return $arg;

    }


}