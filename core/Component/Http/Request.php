<?php 

namespace Core\Component\Http;

use Core\Component\Bag;
use Core\Component\Http\Interfaces\RequestInterface;

class Request implements RequestInterface
{

    public $query = [];
    public $request = [];
    public $attributes = [];
    public $cookies = [];
    public $files = [];
    public $server = [];


    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [])
    {
        $this->query = new Bag($query);
        $this->request = new Bag($request);
        $this->attributes = new Bag($attributes);
        $this->cookies = new Bag($cookies);
        $this->files = new Bag($files);
        $this->server = new Bag($server);
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
        if ($this->server->get('REQUEST_URI') === null) {
            throw new \Exception('Unable to retrieve URI');
        }

        $uri = explode('?',$this->server->get('REQUEST_URI'));
        return $uri[0];
    }


    public function getMethod()
    {
        if ($this->server->get("REQUEST_METHOD") === null) {
            throw new \Exception('Unable to retrieve REQUEST METHOD');
        }

        return $this->server->get("REQUEST_METHOD");
    }


}
