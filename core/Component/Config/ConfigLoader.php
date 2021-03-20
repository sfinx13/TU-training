<?php 

namespace Core\Component\Config;
use Core\Component\Config\ConfigLoaderException;

class ConfigLoader implements ConfigLoaderInterface
{

    private $config = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function get(string $key)
    {
        if (!isset($this->config[$key])) {
            throw new ConfigLoaderException('Index ' . $key . ' is not defined in config/app.php');
        }

        return $this->config[$key];
    }

    public function views(string $key = null)
    {
        
        if (!isset($this->config['views'])) {
            throw new ConfigLoaderException('views is not defined in config/app.php');
        }

        if ($key != null && !isset($this->config['views'][$key])) {
            throw new ConfigLoaderException('"' . $key .'" is not defined in views');
        } 

        return $this->config['views'][$key];

    }

    public function routes(string $key = null)
    {
        
        if (!isset($this->config['routes'])) {
            throw new ConfigLoaderException('Index routes is not defined in config/app.php');
        }

        if ($key != null && !isset($this->config['routes'][$key])) {
            throw new ConfigLoaderException('"' . $key .'" is not defined in routes');
        } 

        return $this->config['routes'][$key];

    }



}