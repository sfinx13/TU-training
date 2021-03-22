<?php

namespace App\Controller;

use Core\Component\Http\Request;
use Core\Component\Controller\BaseController;

class AboutController extends BaseController
{

    public function index(Request $request)
    {
        $this->renderFromTemplate("about/index",[
            'text' => 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.'
        ]);
    }


}

