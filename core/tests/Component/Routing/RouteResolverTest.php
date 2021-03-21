<?php 

namespace Core\Tests;

use PHPUnit\Framework\TestCase;
use Core\Component\Routing\RouteResolver;

class RouteResolverTest extends TestCase
{

    private $requestMock;
    private $routerMock;
    private $routeMock;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->requestMock = $this->getMockBuilder('Core\Component\Http\Request')
            ->getMock();
        $this->routerMock = $this->getMockBuilder("Core\Component\Routing\RouteCollection")
            ->getMock();
        $this->routeMock = $this->getMockBuilder('Core\Component\Routing\Route')
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function routesForTest()
    {
        $routes = [];
        $testRouteMock = $this->routeMock;

        $testRouteMock->method('getName')->willReturn('test');
        $testRouteMock->method('getUri')->willReturn('/test');
        $testRouteMock->method('getController')
            ->willReturn('Fake\Controller\TestController::test');

        $routes[$testRouteMock->getName()] = $testRouteMock;
        return $routes;
    }

    private function router()
    {
        $router = $this->routerMock;
        $router->method('getAll')->willReturn($this->routesForTest());
        return $router;
    }

    public function testResolveSuccess()
    {
        $request = $this->requestMock;
        $request->method('getUri')->willReturn('/test');
        $resolve = (new RouteResolver)
            ->resolve($request, $this->router());

        $this->assertIsObject($resolve);
    }

    public function testResolveError()
    {
        try{
            $request = $this->requestMock;
            $request->method('getUri')->willReturn('/fake');
            (new RouteResolver)->resolve($request, $this->router());
        }
        catch(\Exception $e) {
            $this->assertEquals($e->getMessage(),"Route Not found");
        }
    }



}