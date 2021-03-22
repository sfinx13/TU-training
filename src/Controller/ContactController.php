<?php

namespace App\Controller;

use Core\Component\Controller\BaseController;

class ContactController extends BaseController
{

    public function index()
    {
        $this->renderFromTemplate('contact/index');
    }


}