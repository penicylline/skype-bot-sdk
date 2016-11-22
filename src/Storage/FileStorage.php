<?php

namespace SkypeBot\Storage;


use SkypeBot\Interfaces\DataStorage;

class FileStorage implements DataStorage
{

    protected $path;

    public function __construct($path = null)
    {
        if ($path == null) {
            $path == __DIR__;
        }

        $this->path = $path;
    }

    public function set($key, $value)
    {
        $file = $this->getPathByKey($key);
        file_put_contents($file, serialize($value));
    }

    public function get($key)
    {
        $file = $this->getPathByKey($key);
        if (!file_exists($file)) {
            return null;
        }
        $data = file_get_contents($file);
        return unserialize($data);
    }

    public function remove($key)
    {
        unlink($this->getPathByKey($key));
    }

    private function getPathByKey($key)
    {
        return sprintf('%s/%s.data', $this->path, $key);
    }
}