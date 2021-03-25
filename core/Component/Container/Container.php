<?php


namespace Core\Component\Container;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Container implements ContainerInterface
{
    private $services = [];
    private $mapping = [];

    public function __construct(array $services, array $mapping = [])
    {
        $this->services = $services;
        $this->mapping = $mapping;
    }

    public function get(string $id)
    {

        if (!$this->has($id)) {
            return null;
        }

        $class = $this->services[$id];
        $params = $this->relection($class);
        return $this->giveInstance($params,$class);
    }

    public function has(string $id): bool
    {
        return array_key_exists($id,$this->services);
    }

    public function add(string $id,$class): void
    {
        if (!$this->has($id)) {
            $this->services[$id] = $class;
        }
    }

    public function instanciate(string $class): object
    {
        $params = $this->relection($class);
        return $this->giveInstance($params,$class);
    }

    private function relection($service) {

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

                if($subReflection->isInterface()) {
                    $subService = $this->interfaceMapping($subService,$service);
                }

                $subServiceParams = $this->relection($subService);
                $subserviceInstance = $this->giveInstance($subServiceParams,$subService);

                array_push($params,$subserviceInstance);

            }

        }

        return $params;
    }

    private function interfaceMapping(string $interface, string $originalClass)
    {

        if (!isset($this->mapping[$interface])) {
            throw new \Exception('Please define which class must be instantiated for ' . $interface);
        }

        if(!isset($this->mapping[$interface][$originalClass]) && !isset($this->mapping[$interface]['default'])) {
            throw new \Exception('Please define the default class to instantiate for ' . $interface);
        }

        return isset($this->mapping[$interface][$originalClass]) && class_exists($this->mapping[$interface][$originalClass]) ?
            $this->mapping[$interface][$originalClass]
            : $this->mapping[$interface]['default'];

    }

    private function giveInstance(array $params,string $class): object
    {
        return count($params) > 0 ? new $class(...$params) : new $class;
    }



}
