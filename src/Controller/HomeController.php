<?php 

namespace App\Controller;

use Core\Component\Controller\BaseController;
use Core\Component\Http\Response;
use Core\Component\View;

class HomeController extends BaseController
{

    public function index()
    {   

        $params = [
            'title' => 'Our framework',
            'description' => 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.'
        ];
    
        View::template("home/index",$params);

    }



}

