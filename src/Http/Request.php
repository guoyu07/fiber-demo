<?php

namespace Fiber\Http;

class Request
{
    private $request;
    private $body;

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function getMethod()
    {
        return $this->request['method'];
    }

    public function getUri()
    {
        return $this->request['uri'];
    }

    public function getPath()
    {
        return $this->request['path'];
    }

    public function getHeader(string $name)
    {
        return $this->request['headers'][$name] ?? null;
    }

    public function getArg(string $name)
    {
        return $this->request['args'][$name] ?? null;
    }

    public function getCookie(string $name)
    {
        return $this->request['headers']['Cookie'][$name] ?? null;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }
}
