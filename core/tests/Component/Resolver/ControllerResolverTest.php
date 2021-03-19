<?php 

namespace Core\Tests;

use Core\Component\Resolver\ControllerResolver;
use PHPUnit\Framework\TestCase;

class ControllerResolverTest extends TestCase
{   
    
    private $defaultRoute = [
         "name" => "default",
        "controller" => "Core\Controller\DefaultController::index"
    ];

    private function getCallable() 
    {
        return (new ControllerResolver)->resolve($this->defaultRoute);
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