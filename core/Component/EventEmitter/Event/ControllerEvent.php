<?php

namespace Core\Component\EventEmitter\Event;

use Core\Component\EventEmitter\Event;

class ControllerEvent extends Event
{
    public function __construct(callable $controller)
    {
        $this->data = $controller;
    }
}