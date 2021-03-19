<?php 

namespace Core\Tests;

use Core\Component\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{   

    public function testGetAllIsArray()
    {
        $request = new Request([],[],[],[],[],[]);
        $this->assertIsArray($request->getAll());
    }

    public function testGetAllCountArray()
    {
        $request = new Request([],[],[],[],[],[]);
        $this->assertEquals(6,count($request->getAll()));
    }

    public function testGetUri()
    {
        $_SERVER['REQUEST_URI'] = '/test';
        $request = new Request([],[],[],[],[],$_SERVER);
        $this->assertSame('/test',$request->getUri());
    }

    public function testGetUriThrow()
    {   
        unset($_SERVER['REQUEST_URI']);
        $request = new Request([],[],[],[],[],$_SERVER);
        try{
            $this->assertSame('/test',$request->getUri());
        }
        catch(\Exception $e) {
            $this->assertEquals($e->getMessage(),"Unable to retrieve URI");
        }
    }

    public function testGetMethod()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $request = new Request([],[],[],[],[],$_SERVER);
        $this->assertSame('GET',$request->getMethod());
    }

    public function testGetMethodThrow()
    {
        unset($_SERVER['REQUEST_METHOD']);
        $request = new Request([],[],[],[],[],$_SERVER);
        try{
            $this->assertSame('GET',$request->getMethod());
        }
        catch(\Exception $e) {
            $this->assertEquals($e->getMessage(),"Unable to retrieve REQUEST METHOD");
        }
    }

    
}