<?php 

namespace Core\Component\Controller;

class DefaultController extends BaseController
{

    public function index()
    {
        $title = "Our framework";
        $description = "Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.";
        require_once dirname(__DIR__) . '/../views/default.php';
    }


}