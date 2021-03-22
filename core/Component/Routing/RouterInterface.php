<?php

namespace Core\Component\Routing;

use Core\Component\Http\Interfaces\RequestInterface;

interface RouterInterface
{

    public function add(string $name, string $uri, callable $callback, array $regex = [], array $params = []): Route;

    public function remove(string $name): void;

    public function search(string $name): ?Route;

    public function match(RequestInterface $request): ?Route;

}

