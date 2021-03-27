<?php 

namespace Core\Component\Config;
use Core\Component\Config\ConfigLoaderException;

class ConfigLoader implements ConfigLoaderInterface
{

    public const VIEW_INDEX = 'views';
    public const ROUTE_INDEX = 'routes';
    public const DB_INDEX = 'db';
    public const EVENT_INDEX = 'events';

    public static $config = [];

    public function load(array $config) {
        self::$config = $config;
    }

    public function get(string $key)
    {
        if (!isset(self::$config[$key])) {
            throw new ConfigLoaderException('Index ' . $key . ' is not defined in config/app.php');
        }

        return self::$config[$key];
    }

    public function views(string $key = null)
    {
        
        if (!isset(self::$config[self::VIEW_INDEX])) {
            throw new ConfigLoaderException('views is not defined in config/app.php');
        }

        if ($key !== null && !isset(self::$config[self::VIEW_INDEX][$key])) {
            throw new ConfigLoaderException('"' . $key .'" is not defined in views');
        } 

        return self::$config[self::VIEW_INDEX][$key];

    }

    public function events(string $key = null)
    {

        if (!isset(self::$config[self::EVENT_INDEX])) {
            throw new ConfigLoaderException('events is not defined in config/app.php');
        }

        if ($key !== null && !isset(self::$config[self::EVENT_INDEX][$key])) {
            throw new ConfigLoaderException('"' . $key .'" is not defined in events');
        }

        return self::$config[self::EVENT_INDEX][$key];
    }

    public function routes(string $key = null)
    {
        
        if (!isset(self::$config[self::ROUTE_INDEX])) {
            throw new ConfigLoaderException('Index routes is not defined in config/app.php');
        }

        if ($key != null && !isset(self::$config[self::ROUTE_INDEX][$key])) {
            throw new ConfigLoaderException('"' . $key .'" is not defined in routes');
        } 

        return self::$config[self::ROUTE_INDEX][$key];

    }



}