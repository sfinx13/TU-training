<?php

namespace App\Controller;

use Core\Component\Http\Request;
use Core\Component\Controller\BaseController;

class AboutController extends BaseController
{

    public function index(Request $request)
    {
        $this->renderFromTemplate("about/index",[
            'text' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book."
        ]);
    }


}

