<?php

namespace Fiber\Biz;

class Memcache
{
    public function set($key, $value)
    {
        $db = new \Fiber\Memcache\Connection('127.0.0.1');

        return $db->set($key, $value);
    }

    public function get($key)
    {
        $db = new \Fiber\Memcache\Connection('127.0.0.1');

        return $db->get($key);
    }
}
