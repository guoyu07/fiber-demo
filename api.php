<?php
/** @var FastRoute\RouteCollector $r */

$r->get('/sleep[/{time_ms:\d+}]', 'Fiber\Biz\Sleep@foo');
$r->get('/db/query[/{limit:\d+}]', 'Fiber\Biz\Mysql@foo');
$r->get('/dig[/{name}]', 'Fiber\Biz\Dns@dig');
$r->get('/head', 'Fiber\Biz\Http@foo');
