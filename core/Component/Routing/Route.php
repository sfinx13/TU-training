<?php 

namespace Core\Component\Routing;

class Route
{

    private $name;

    private $uri;

    private $controller;


    public function __construct(string $name,string $uri, string $controller)
    {
        $this->name = $name;
        $this->uri = $uri;
        $this->controller = $controller;
    }

    public function getName():string
    {
        return $this->name;
    }


    public function getUri(): string
    {
        return $this->uri;
    }

    public function getController(): string
    {
        return $this->controller;
    }


}
