<?php
/** @var FastRoute\RouteCollector $r */

$r->get('/sleep[/{time_ms:\d+}]', 'Fiber\Biz\Sleep@foo');
$r->get('/db/query[/{limit:\d+}]', 'Fiber\Biz\Mysql@foo');
$r->get('/dig[/{name}]', 'Fiber\Biz\Dns@dig');
$r->get('/head', 'Fiber\Biz\Http@foo');
$r->post('/redis/{name}/{value}', 'Fiber\Biz\Redis@set');
$r->get('/redis/{name}', 'Fiber\Biz\Redis@get');
$r->post('/memc/{name}/{value}', 'Fiber\Biz\Memcache@set');
$r->get('/memc/{name}', 'Fiber\Biz\Memcache@get');
