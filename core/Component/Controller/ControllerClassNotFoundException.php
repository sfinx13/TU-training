<?php

namespace Core\Component\Controller;

use Core\Component\Http\Response;

class ControllerClassNotFoundException extends \Exception
{
    public function __construct($message, $code = Response::HTTP_NOT_FOUND)
    {
        parent::__construct($message, $code);
    }

    public function __toString()
    {
        return $this->message;
    }


}