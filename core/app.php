<?php 

namespace Core;
use Core\Component\Http\Request;

class App 
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function run()
    {    
        echo 'Mon application';
    }

}


