<?php 

namespace Core\Tests;

use Core\Component\Http\Factory\RequestFactory;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{

    public function testGetUri()
    {
        $_SERVER['REQUEST_URI'] = '/test';
        $request = RequestFactory::create();
        $this->assertSame('/test',$request->getUri());
    }

    
}