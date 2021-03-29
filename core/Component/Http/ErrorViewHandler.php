<?php

namespace Core\Component\Http;

class ErrorViewHandler
{

    public static function show(\Exception $e)
    {
        $message = $e->getMessage();
        $errorViews = PROJECT_DIR . '/core/views/errors/404.php';

        if (file_exists($errorViews)) {
            ob_start();
            include_once $errorViews;
            $message = ob_get_contents();
            ob_clean();
            ob_flush();
        }

        return $message;
    }


}