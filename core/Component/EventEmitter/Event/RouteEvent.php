<?php

namespace Core\Component\EventEmitter\Event;

use Core\Component\EventEmitter\Event;
use QH\Routing\Route\Route;

class RouteEvent extends Event
{
    public function __construct(Route $route)
    {
        $this->data = $route;
    }
}

