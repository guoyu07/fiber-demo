<?php

namespace Fiber\Biz;

class Http
{
    public function foo()
    {
        $http = \Fiber\Http\Client::create(['base_uri' => 'http://myip.ipip.net']);
        $response = $http->request('GET', '/');

        return (string) $response->getBody();
    }
}
