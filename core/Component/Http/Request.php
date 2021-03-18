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
        $all = [];
        $all['query'] = $this->query;
        $all['request'] = $this->request;
        $all['attributes'] = $this->attributes;
        $all['cookies'] = $this->cookies;
        $all['files'] = $this->files;
        $all['server'] = $this->server;

        return $all;
    }


    public function getUri(): string
    {
        $uri = '/';
        if (isset($this->server['REQUEST_URI'])) {
            $uri = $this->server['REQUEST_URI'];
        }
        return $uri;
    }


}
