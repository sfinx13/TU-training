<?php 

namespace Core\Component\Controller;

use Core\AppFactory;
use Core\Component\Config\ConfigLoader;
use Core\Component\Http\Response;

abstract class BaseController
{


    protected function renderToHtml(string $html,$statusCode = Response::HTTP_OK)
    {
        printf(new Response($html,$statusCode));
    }

    protected function renderFromTemplate(string $templatePath,array $params = [],$statusCode = Response::HTTP_OK)
    {

        if (!isset($this->getConfig(ConfigLoader::VIEW_INDEX)['path'])) {
            throw new \Exception('The directory for the views is not defined in config/app.php');
        }

        if (!file_exists($this->getConfig(ConfigLoader::VIEW_INDEX)['path'])) {
            throw new \Exception($this->getConfig(ConfigLoader::VIEW_INDEX)['path'] . ' does not exist');
        }
   
        extract($params);

        ob_start();
        
            include_once $this->getConfig(ConfigLoader::VIEW_INDEX)['path'] . '/' . $templatePath . '.php';
            $html = ob_get_contents();
            ob_clean();

        ob_flush();

        printf(new Response($html,$statusCode));

    }


    protected function getConfig(string $key)
    {
        $configLoader = (new AppFactory)->configLoaderInstance();
        return $configLoader->get($key);
    }



}