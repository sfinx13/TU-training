<?php 

namespace Core\Component\Resolver;

use Core\Component\Http\Interfaces\RequestInterface;

interface RouteResolverInterface
{
    public function resolve(RequestInterface $request): array;
}
