<?php

namespace Fiber\Http;

use Fiber\Helper as f;

class Parser
{
    public function parse($buf): Request
    {
        $lines = explode("\r\n", $buf);

        $request_line = array_shift($lines);
        $request = $this->parseRequestLine($request_line);

        $headers = $this->parseHeader($lines);

        if (isset($headers['Cookie'])) {
            $headers['Cookie'] = $this->parserCookie($headers['Cookie']);
        }

        $request['headers'] = $headers;

        return new Request($request);
    }

    public function parseRequestLine($line)
    {
        $first_blank_idx = strpos($line, ' ');
        $method = strtoupper(substr($line, 0, $first_blank_idx));

        $http_idx = stripos($line, 'HTTP/');
        $version = substr($line, $http_idx + 5);
        $uri = trim(substr($line, $first_blank_idx, $http_idx - $first_blank_idx));

        $question_idx = strpos($uri, '?');
        if ($question_idx) {
            $path = urldecode(substr($uri, 0, $question_idx));

            $args = substr($uri, $question_idx + 1);
            $args = $this->parseArgs($args);
        } else {
            $path = urldecode($uri);
            $args = [];
        }

        return [
            'method' => $method,
            'uri' => $uri,
            'path' => $path,
            'version' => $version,
            'args' => $args,
        ];
    }

    public function parseArgs(string $line)
    {
        $args = [];
        foreach (explode('&', $line) as $arg) {
            $parts = explode('=', $arg);
            if (!$parts) {
                continue;
            }

            $name = urldecode($parts[0]);
            $value = urldecode($parts[1]);

            $name_len = strlen($name);
            /*if ($name[$name_len - 1] === ']' && $name[$name_len - 2] === '[') {
                // TODO support $a['x']=1&$a['y']=2
                $name = substr($name, 0, $name_len - 2);
                $args[$name][] = $value;
            } else*/ {
                $args[$name] = $value;
            }
        }

        return $args;
    }

    public function parseHeader(array $lines)
    {
        $headers = [];

        foreach ($lines as $line) {
            if (!$line) {
                continue;
            }

            $colon_idx = strpos($line, ':');
            if ($colon_idx <= 0) {
                continue;
            }

            $name = trim(substr($line, 0, $colon_idx));
            $value = trim(substr($line, $colon_idx + 1));

            $headers[ucwords($name, '-')] = $value;
        }

        return $headers;
    }

    public function parserCookie(string $line)
    {
    }
}
