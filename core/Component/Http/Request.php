<?php 

namespace Core\Component\Http;

use Core\Component\Bag;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

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


    public function getProtocolVersion()
    {
        // TODO: Implement getProtocolVersion() method.
    }

    public function withProtocolVersion($version)
    {
        // TODO: Implement withProtocolVersion() method.
    }

    public function getHeaders()
    {
        // TODO: Implement getHeaders() method.
    }

    public function hasHeader($name)
    {
        // TODO: Implement hasHeader() method.
    }

    public function getHeader($name)
    {
        // TODO: Implement getHeader() method.
    }

    public function getHeaderLine($name)
    {
        // TODO: Implement getHeaderLine() method.
    }

    public function withHeader($name, $value)
    {
        // TODO: Implement withHeader() method.
    }

    public function withAddedHeader($name, $value)
    {
        // TODO: Implement withAddedHeader() method.
    }

    public function withoutHeader($name)
    {
        // TODO: Implement withoutHeader() method.
    }

    public function getBody()
    {
        // TODO: Implement getBody() method.
    }

    public function withBody(StreamInterface $body)
    {
        // TODO: Implement withBody() method.
    }

    public function getRequestTarget()
    {
        // TODO: Implement getRequestTarget() method.
    }

    public function withRequestTarget($requestTarget)
    {
        // TODO: Implement withRequestTarget() method.
    }

    public function withMethod($method)
    {
        // TODO: Implement withMethod() method.
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        // TODO: Implement withUri() method.
    }
}
