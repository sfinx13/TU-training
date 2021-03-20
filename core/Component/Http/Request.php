<?php 

namespace Core\Component\Http;

use Core\Component\Http\Interfaces\RequestInterface;

class Request implements RequestInterface
{

    private $query = [];
    private $request = [];
    private $attributes = [];
    private $cookies = [];
    private $files = [];
    private $server = [];


    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [])
    {
        $this->query = $query;
        $this->request = $request;
        $this->attributes = $attributes;
        $this->cookies = $cookies;
        $this->files = $files;
        $this->server = $server;
    }

    public function getAll(): array
    {
        return [
            'query' => $this->query,
            'request' => $this->request,
            'attributes' => $this->attributes,
            'cookies' => $this->cookies,
            'files' => $this->files,
            'server' => $this->server,
        ];

    }


    public function getUri(): string
    {
        if (!isset($this->server['REQUEST_URI'])) {
            throw new \Exception('Unable to retrieve URI');
        }

        $uri = explode('?',$this->server['REQUEST_URI']);
        return $uri[0];
    }


    public function getMethod()
    {
        if (!isset($this->server['REQUEST_METHOD'])) {
            throw new \Exception('Unable to retrieve REQUEST METHOD');
        }

        return $this->server['REQUEST_METHOD'];
    }


}
