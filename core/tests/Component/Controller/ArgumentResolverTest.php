<?php 

namespace Core\Tests\Component\Controller;

use Core\Component\Controller\ArgumentResolver;
use Core\Component\Controller\DefaultController;
use PHPUnit\Framework\TestCase;

class ArgumentResolverTest extends TestCase
{

    public function defaultControllerMock()
    {
        return $this->createMock(DefaultController::class);
    }
    
    public function testResolveWithoutParams()
    {
        $mock = $this->defaultControllerMock();
        $mock->method('index')
            ->willReturn('Default view');

        $controller = [new $mock,'index'];

        $argumentResolver = new ArgumentResolver;
        $args = $argumentResolver->resolve($controller);

        $this->assertEquals(0,count($args));

    }




}