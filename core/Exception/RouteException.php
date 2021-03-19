<?php 

namespace Core\Exception;

use Core\Component\Http\Response;

class RouteException extends \Exception
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