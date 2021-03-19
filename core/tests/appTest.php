<?php 

namespace Core\Tests;

use PHPUnit\Framework\TestCase;
use Core\App;
use Core\Component\Http\Factory\RequestFactory;

class AppTest extends TestCase
{

    public function testRun()
    {   
        //$request = RequestFactory::create();
        //$app = new App($request);
        $this->assertSame(1,1);
    }
    

}