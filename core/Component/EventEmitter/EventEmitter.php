<?php

namespace Core\Component\EventEmitter;

class EventEmitter implements EventEmitterInterface
{

    private $listener = [];

    public function emit(string $eventName, Event $event): void
    {
        if ($this->hasListener($eventName)) {
            foreach ($this->listener[$eventName] as $callable) {
                $callable($event);
            }
        }
    }

    public function listen(string $eventName, callable $callback)
    {
        if (!$this->hasListener($eventName)) {
            $this->listener[$eventName] = [];
        }
        $this->listener[$eventName][] = $callback;
    }


    public function hasListener(string $eventName): bool
    {
        return array_key_exists($eventName,$this->listener);
    }



}