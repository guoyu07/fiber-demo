<?php

namespace Fiber\Biz;

class Redis
{
    public function set($key, $value)
    {
        $db = new \Fiber\Redis\Connection('127.0.0.1');

        return $db->set($key, $value);
    }

    public function get($key)
    {
        $db = new \Fiber\Redis\Connection('127.0.0.1');

        return $db->get($key);
    }
}
