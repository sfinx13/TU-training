<?php 

namespace Core\Component\Config;

interface ConfigLoaderInterface
{
    
    public function get(string $key);

}