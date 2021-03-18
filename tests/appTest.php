<?php 

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\App;

class AppTest extends TestCase
{

    public function testRun()
    {   
        $app = new App;
        $this->assertSame($app->run(),'Mon application');
    }
    

}