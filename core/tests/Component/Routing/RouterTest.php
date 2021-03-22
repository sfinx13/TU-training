<?php

namespace Core\Tests;

use Core\Component\Routing\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{

    private $router;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->router = new Router;
    }

    public function testRouterAddRoute()
    {
        $router = $this->router;
        $homeCallBack = function(){ echo 'Home Page'; };
        $route = $router->add('homeTest','/',$homeCallBack);
        $this->assertIsObject($route);
    }


}