<?php

namespace App\Controller;

use Core\Component\Controller\BaseController;

class TeamsController extends BaseController
{

    public function index()
    {
        $this->renderFromTemplate('teams/index');
    }

}