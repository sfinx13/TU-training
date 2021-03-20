<?php 

namespace Core\Component\Config;

use Core\Component\Http\Response;

class ConfigLoaderException extends \Exception
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