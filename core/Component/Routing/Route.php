<?php 

namespace Core\Component\Routing;

class Route
{

    private $name;
    private $uri;
    private $callback;
    private $regex;
    private $params;

    public function __construct(string $name,string $uri, callable $callback, array $regex = [], array $params = [])
    {
        $this->name = $name;
        $this->uri = $uri;
        $this->callback = $callback;
        $this->regex = $regex;
        $this->params = $params;
    }

    public function getName():string
    {
        return $this->name;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getCallback(): callable
    {
        return $this->callback;
    }

    public function getRegex(): array
    {
        return $this->regex;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setUri(string $uri): self
    {
        $this->uri = $uri;
        return $this;
    }

    public function setCallback(callable $callback): self
    {
        $this->callback = $callback;
        return $this;
    }

    public function setRegex(array $regex): self
    {
        $this->regex = $regex;
        return $this;
    }

    public function setParams(array $params): self
    {
        $this->params = $params;
        return $this;
    }


}
