<?php 

namespace Core\Component\Controller;

interface ArgumentResolverInterface
{
    public function resolve(array $controller): array;
}