<?php

namespace SkypeBot\Storage;


use SkypeBot\Interfaces\DataStorage;

class MemoryStorage implements DataStorage
{

    protected $data;

    public function __construct()
    {
        $this->data = array();
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function get($key)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }
    }

    public function remove($key)
    {
        unset($this->data[$key]);
    }
}