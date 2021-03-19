<?php 

namespace Core\Tests;

use Core\Component\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{

    public function testGetUri()
    {
        $_SERVER['REQUEST_URI'] = '/test';
        $request = new Request([],[],[],[],[],$_SERVER);
        $this->assertSame('/test',$request->getUri());
    }

    public function testGetMethod()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $request = new Request([],[],[],[],[],$_SERVER);
        $this->assertSame('GET',$request->getMethod());
    }

    
}