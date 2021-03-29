<?php 

namespace Core\Tests\Component\Controller;

use Core\Component\Controller\ArgumentResolver;
use PHPUnit\Framework\TestCase;

class ArgumentResolverTest extends TestCase
{

    private $defaultControllerMock;
    private $routeMock;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->defaultControllerMock = $this->createMock("Core\Component\Controller\DefaultController");
        $this->routeMock = $route = $this->getMockBuilder('QH\Routing\Route\Route')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testArgumentsResolveReturnEmptyArray()
    {
        $mock = $this->defaultControllerMock;
        $mock->method('index')
            ->willReturn('Default view');

        $controller = [new $mock,'index'];

        $route = $this->routeMock;
        $route
            ->method('getParams')->willReturn([]);
        ;

        $argumentResolver = new ArgumentResolver;
        $args = $argumentResolver->resolve($controller,$route);

        $this->assertEquals(0,count($args));

    }




}