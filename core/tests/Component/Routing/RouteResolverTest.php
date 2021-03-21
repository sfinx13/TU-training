<?php 

namespace Core\Tests;

use PHPUnit\Framework\TestCase;
use Core\Component\Routing\RouteResolver;

class RouteResolverTest extends TestCase
{

    private function routesForTest()
    {
        $routes = [];
        $testRouteMock = $this->getMockBuilder('Core\Component\Routing\Route')
            ->disableOriginalConstructor()
            ->getMock();

        $testRouteMock->method('getName')->willReturn('test');
        $testRouteMock->method('getUri')->willReturn('/test');
        $testRouteMock->method('getController')
            ->willReturn('Fake\Controller\TestController::test');

        $routes[$testRouteMock->getName()] = $testRouteMock;
        return $routes;
    }

    private function router()
    {
        $router = $this->getMockBuilder("Core\Component\Routing\RouteCollection")
                ->getMock();
        $router->method('getAll')->willReturn($this->routesForTest());

        return $router;
    }

    private function requestMock()
    {
        return $this->getMockBuilder('Core\Component\Http\Request')
            ->getMock();
    }

    public function testResolveIsObject()
    {
        $request = $this->requestMock();
        $request->method('getUri')->willReturn('/test');
        $resolve = (new RouteResolver)
            ->resolve($request,$this->router());

        $this->assertIsObject($resolve);
    }

    public function testResolveIsThrowError()
    {
        try{
            $request = $this->requestMock();
            $request->method('getUri')->willReturn('/fake');
            (new RouteResolver)->resolve($request,$this->router());
        }
        catch(\Exception $e) {
            $this->assertEquals($e->getMessage(),"Route Not found");
        }
    }



}