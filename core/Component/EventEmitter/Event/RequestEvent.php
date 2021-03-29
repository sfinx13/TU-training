<?php

namespace Core\Component\EventEmitter\Event;

use Core\Component\EventEmitter\Event;
use Psr\Http\Message\RequestInterface;

class RequestEvent extends Event
{
    public function __construct(RequestInterface $request)
    {
        $this->data = $request;
    }
}

