<?php 

namespace Core\Tests\Component\Controller;

use Core\Component\Controller\ControllerResolver;
use QH\Routing\Route\Route;
use PHPUnit\Framework\TestCase;

class ControllerResolverTest extends TestCase
{   

    private $controllerResolver;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->controllerResolver = new ControllerResolver;
    }

    public function testControllerResolveReturnAControllerCallable()
    {
      $route = new Route(
          'default',
                '/',
                'Core\Component\Controller\DefaultController::index'
      );
      $controller = $this->controllerResolver->resolve($route);
      $this->assertIsCallable($controller);

    }

    public function testControllerResolveReturnAClosureCallable()
    {
        $func =  function(){echo 'Test';};
        $route = new Route(
            'default',
            '/',
            $func
        );
        $controller = $this->controllerResolver->resolve($route);
        $this->assertIsCallable($controller);
    }


}