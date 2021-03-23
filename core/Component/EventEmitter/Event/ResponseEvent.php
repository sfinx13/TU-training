<?php

namespace Core\Component\EventEmitter\Event;

use Core\Component\EventEmitter\Event;
use Core\Component\Http\Interfaces\ResponseInterface;

class ResponseEvent extends Event
{
    public function __construct(ResponseInterface $response)
    {
        $this->data = $response;
    }
}

