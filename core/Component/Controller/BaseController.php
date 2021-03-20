<?php 

namespace Core\Component\Controller;

use Core\Component\Http\Response;

abstract class BaseController
{


    protected function renderToHtml(string $html,$statusCode = Response::HTTP_OK)
    {
        printf(new Response($html,$statusCode));
    }

    protected function renderFromTemplate(string $templatePath,array $params = [],$statusCode = Response::HTTP_OK)
    {

        extract($params);

        ob_start();
        
            include_once dirname(__DIR__) . '/../../views/' . $templatePath . '.php';
            $html = ob_get_contents();
            ob_clean();

        ob_flush();

        printf(new Response($html,$statusCode));

    }


}