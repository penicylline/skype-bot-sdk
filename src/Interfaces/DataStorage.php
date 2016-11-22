<?php

namespace SkypeBot\Interfaces;

interface DataStorage
{
    public function set($key, $value);
    public function get($key);
    public function remove($key);
}