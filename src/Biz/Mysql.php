<?php

namespace Fiber\Biz;

class Mysql
{
    function foo($limit = 2)
    {
        $config = new \Fiber\Mysql\Config();
        $config->user = 'root';
        $config->pass = 'hjkl';
        $config->db   = 'test';
        $config->host = '127.0.0.1';
        $config->port = 3306;

        $db = new \Fiber\Mysql\Connection($config);
        return $db->query("select * from books limit $limit");
    }
}
