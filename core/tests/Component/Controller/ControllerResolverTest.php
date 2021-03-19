<?php 

namespace Core\Tests\Component\Controller;

use Core\Component\Controller\ControllerResolver;
use Core\Component\Routing\Route;
use PHPUnit\Framework\TestCase;

class ControllerResolverTest extends TestCase
{   
    
    public function defaultRoute()
    {
        return new Route("default","/","Core\Component\Controller\DefaultController::index");
    }

    private function getCallable() 
    {
        return (new ControllerResolver)->resolve($this->defaultRoute());
    }

    public function testResolveIsArray()
    {   
        $this->assertIsArray($this->getCallable());
    }

    public function testResolveCount()
    {
        $this->assertEquals(2,count($this->getCallable()));
    }

    public function testResolveIsCallable()
    {
        $this->assertIsCallable($this->getCallable());
    }


}