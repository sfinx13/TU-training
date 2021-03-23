<?php

namespace Core\Component\EventEmitter;


interface EventEmitterInterface
{

    public function emit(string $eventName,Event $event): void;

    public function listen(string $eventName, callable $callback);

}