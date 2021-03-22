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
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.'
        ];
    
        $this->renderFromTemplate("home/index",$params);
    }


    public function about(string $name,int $age)
    {
        dd('Votre nom est:  ' . $name . ', Votre âge est : ' . $age .' ans');
    }


}

