<?php


namespace Core\Component\Container;

use phpDocumentor\Reflection\Types\Mixed_;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Container implements ContainerInterface
{
    private static $services = [];
    private static $mapping = [];

    public function __construct(array $services = [], array $mapping = [])
    {
        if(!empty($services)) {
            self::$services = $services;
        }

        if(!empty($mapping)) {
            self::$mapping = $mapping;
        }

    }

    public function get(string $id)
    {
        if (!$this->has($id)) {
            return null;
        }

        /**
         * @extract if $this->>services[$id] is an array, waiting $class (required), $parameters (optional)
         */
        extract(self::$services[$id]);
        $params = isset($parameters) ? $parameters : $this->relection($class);
        return $this->giveInstance($params,$class);
    }

    public function has(string $id): bool
    {
        return array_key_exists($id,self::$services);
    }

    public function add(string $id,array $service): void
    {
        if ($this->has($id)) {
            throw new \Exception($id . ' is defined');
        }

        if (!isset($service['class'])) {
            throw new \Exception('Index "class" is not defined');
        }

        self::$services[$id] = $service;
    }

    public function addMapping(string $toMap,$params): void
    {
        self::$mapping[$toMap] = $params;
    }

    public function instanciate(string $class): object
    {
        $params = $this->relection($class);
        return $this->giveInstance($params,$class);
    }

    private function relection($service)
    {
        if(!class_exists($service)) {
            throw new \Exception('class ' .$service. ' not found');
        }

        $params = [];
        $reflection = new \ReflectionClass($service);
        $constructor = $reflection->getConstructor();

        if ($constructor != null && count($constructor->getParameters()) > 0) {

            foreach($constructor->getParameters() as $param) {

                $subService = $param->getType()->getName();

                $subReflection = new \ReflectionClass($subService);
                $subServiceExisting = $this->serviceByClassName($subService);

                if ($subReflection->isInterface()) {
                    $subService = $this->interfaceMapping($subService, $service);
                }

                if (gettype($subService) == "object") {
                    $subserviceInstance = $subService;
                }
                else {
                    $subServiceParams =  $subServiceExisting && isset($subServiceExisting['parameters']) ?
                        $subServiceExisting['parameters']
                        : $this->relection($subService);

                    $subserviceInstance = $this->giveInstance($subServiceParams, $subService);
                }

                array_push($params, $subserviceInstance);

            }

        }

        return $params;
    }

    private function interfaceMapping(string $interface, string $originalClass)
    {

        $map = self::$mapping[$interface];

        if (!isset($map)) {
            throw new \Exception('Please define which class must be instantiated for ' . $interface);
        }

        if(is_array($map) && !isset($map[$originalClass])) {
            throw new \Exception('Please define the default class to instantiate for ' . $interface);
        }

        if(is_array($map) && !class_exists($map[$originalClass])) {
            throw new \Exception('The class "'.$map[$originalClass].'" don\'t exist');
        }

        if(!is_array($map) && !$this->has($map)) {
            throw new \Exception($map . ' is not defined as a service');
        }

        if(!is_array($map)) {
            return $this->get($map);
        }

        return self::$mapping[$interface][$originalClass];

    }

    private function giveInstance(array $params,string $class): object
    {
        return count($params) > 0 ? new $class(...$params) : new $class;
    }

    public function serviceByClassName(string $class): ?array
    {
        $service = null;

        foreach(self::$services as $s) {
            if(isset($s['class']) && $s['class'] == $class) {
                $service = $s;
            }
        }

        return $service;
    }


}
