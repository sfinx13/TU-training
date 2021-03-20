<?php 

namespace Core\Component\Http\Interfaces;

interface RequestInterface
{
    
    public function getAll(): array;

    public function getUri(): string;

}