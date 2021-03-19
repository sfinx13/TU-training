<?php 

namespace Core\Component\Controller;

class DefaultController extends BaseController
{

    public function index()
    {
        echo '<h1>Page par défaut</h1><p>Merci de créer votre première route.</p>';
    }

}