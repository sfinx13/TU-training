<?php 

namespace Core\Component;

use Core\Component\Http\Response;

class View
{

    public static function html($html,$statusCode = Response::HTTP_OK)
    {
        printf(new Response($html,$statusCode));
    }


    public static function template(string $templatePath,array $params = [],$statusCode = Response::HTTP_OK)
    {
        extract($params);

        ob_start();
        
            include_once dirname(__DIR__) . '/../views/' . $templatePath . '.php';
            $html = ob_get_contents();
            ob_clean();

        ob_flush();

        printf(new Response($html,$statusCode));
    
    }


}