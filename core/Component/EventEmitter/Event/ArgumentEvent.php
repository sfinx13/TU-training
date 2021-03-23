<?php

namespace Core\Component\EventEmitter\Event;

use Core\Component\EventEmitter\Event;

class ArgumentEvent extends Event
{
    public function __construct(array $argument)
    {
        $this->data = $argument;
    }

}

