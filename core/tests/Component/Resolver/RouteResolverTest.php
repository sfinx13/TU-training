<?php 

namespace Core\Tests;

use PHPUnit\Framework\TestCase;
use Core\Component\Http\Request;
use Core\Component\Resolver\RouteResolver;

class RouteResolverTest extends TestCase
{

    private function getRouteResolved()
    {
        $_SERVER['REQUEST_URI'] = '/';
        $request = new Request([],[],[],[],[],$_SERVER);

        $routeResolver = new RouteResolver();
        return $routeResolver->resolve($request);
    }

    public function testResolveIsArray()
    {
        $this->assertIsArray($this->getRouteResolved());
    }

    public function testResolveIsArrayHasKeyController()
    {
        $this->assertArrayHasKey("controller",$this->getRouteResolved());
    }

    public function testResolveIsArrayHasKeyName()
    {
        $this->assertArrayHasKey("name",$this->getRouteResolved());
    }


}