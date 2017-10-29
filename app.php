<?php
require __DIR__.'/vendor/autoload.php';

use Amp\Loop;
use Fiber\Helper as f;
use FastRoute as r;

$server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($server, SOL_SOCKET, SO_REUSEADDR, 1);
socket_set_nonblock($server);
socket_bind($server, '0.0.0.0', 8080);
socket_listen($server, 256);

$dispatcher = r\simpleDispatcher(function($r) { require __DIR__.'/api.php'; });

function biz($client)
{
    try {
        $headers = f\find($client, "\r\n\r\n");
        if (!$headers) {
            return socket_close($client);
        }

        $parser = new Fiber\Http\Parser;
        $request = $parser->parse($headers);

        $content_length = $request->getHeader('Content-Length') ?: 0;
        $body = f\read($client, $content_length);

        global $dispatcher;

        $info = $dispatcher->dispatch($request->getMethod(), $request->getPath());
        switch ($info[0]) {
        case r\Dispatcher::FOUND:
            list($class, $method) = explode('@', $info[1]);
            $biz = new $class;
            $body = call_user_func_array([$biz, $method], $info[2]);
            if (!is_string($body)) $body = json_encode($body, JSON_UNESCAPED_UNICODE);
            f\write($client, "HTTP/1.0 200 OK\r\n");
            f\write($client, "Content-Length: ".strlen($body)."\r\n\r\n".$body);
            break;
        default:
            f\write($client, "HTTP/1.0 404 Not Found\r\n\r\n");
            socket_close($client);
        }
    } catch (\Throwable $t) {
        echo $t->getMessage(),' ',$t->getFile(),' ',$t->getLine(), "\n",
            $t->getTraceAsString(), "\n";
        f\write($client, "HTTP/1.0 400 Bad Request\r\n\r\n");
        socket_close($client);
    }
}

Loop::onReadable($server, function ($id, $server) {
    $client = socket_accept($server);
    socket_set_nonblock($client);

    $fiber = new Fiber(Closure::fromCallable('biz'));

    f\run($fiber, $client);
});

Loop::run();
