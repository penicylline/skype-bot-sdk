<?php

namespace SkypeBot\Storage;


use SkypeBot\Interfaces\ApiLogger;

class SimpleApiLogger implements ApiLogger
{
    private $handler;
    public function __construct()
    {
        if (php_sapi_name() === 'cli') {
            $this->handler = fopen('php://output', 'w');
        } else {
            $this->handler = fopen('php://memory', 'w');
        }
    }

    public function __destruct()
    {
        if ($this->handler) {
            fclose($this->handler);
        }
    }

    public function log($message)
    {
        fwrite($this->handler, $message);
        fwrite($this->handler, PHP_EOL);
    }
}