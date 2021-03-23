<?php 

namespace Core\Component\Config;
use Core\Component\Config\ConfigLoaderException;

class ConfigLoader implements ConfigLoaderInterface
{

    public const VIEW_INDEX = 'views';
    public const ROUTE_INDEX = 'routes';
    public const DB_INDEX = 'db';
    public const EVENT_INDEX = 'events';

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
        
        if (!isset($this->config[self::VIEW_INDEX])) {
            throw new ConfigLoaderException('views is not defined in config/app.php');
        }

        if ($key !== null && !isset($this->config[self::VIEW_INDEX][$key])) {
            throw new ConfigLoaderException('"' . $key .'" is not defined in views');
        } 

        return $this->config[self::VIEW_INDEX][$key];

    }

    public function events(string $key = null)
    {

        if (!isset($this->config[self::EVENT_INDEX])) {
            throw new ConfigLoaderException('events is not defined in config/app.php');
        }

        if ($key !== null && !isset($this->config[self::EVENT_INDEX][$key])) {
            throw new ConfigLoaderException('"' . $key .'" is not defined in events');
        }

        return $this->config[self::EVENT_INDEX][$key];
    }

    public function routes(string $key = null)
    {
        
        if (!isset($this->config[self::ROUTE_INDEX])) {
            throw new ConfigLoaderException('Index routes is not defined in config/app.php');
        }

        if ($key != null && !isset($this->config[self::ROUTE_INDEX][$key])) {
            throw new ConfigLoaderException('"' . $key .'" is not defined in routes');
        } 

        return $this->config[self::ROUTE_INDEX][$key];

    }



}