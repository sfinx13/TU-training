<?php 

namespace Core\Tests;

use PHPUnit\Framework\TestCase;
use Core\Component\Http\Request;
use Core\Component\Routing\RouteResolver;
use Core\Component\Routing\RouteCollection;

class RouteResolverTest extends TestCase
{

    private function routes()
    {
        $routes = new RouteCollection;
        $routes->addRouteDirectly('test','/test','ControllerFortesting::test');
        return $routes;
    }

    private function getRouteResolved()
    {
        $_SERVER['REQUEST_URI'] = '/';
        $request = new Request([],[],[],[],[],$_SERVER);
        return (new RouteResolver)->resolve($request,$this->routes());
    }

    private function getRouteResolvedFake()
    {
        $_SERVER['REQUEST_URI'] = '/fake';
        $request = new Request([],[],[],[],[],$_SERVER);

        return (new RouteResolver)->resolve($request,$this->routes());
    }

    public function testResolveIsObject()
    {
        $this->assertIsObject($this->getRouteResolved());
    }

    public function testResolveIsThrowError()
    {
        try{
            $this->getRouteResolvedFake();
        }
        catch(\Exception $e) {
            $this->assertEquals($e->getMessage(),"Route Not found");
        }
    }

    


}