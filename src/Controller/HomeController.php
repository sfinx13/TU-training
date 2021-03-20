<?php 

namespace App\Controller;

use Core\Component\Http\Request;
use Core\Component\Controller\BaseController;

class HomeController extends BaseController
{

    public function index(Request $request)
    {   

        $params = [
            'title' => 'Our framework',
            'description' => 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.'
        ];
    
        $this->renderFromTemplate("home/index",$params);

    }


    public function test()
    {
        dd('test');
    }



}

