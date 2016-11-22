<?php

spl_autoload_register(function($class) {
    $mapping = [
        'SkypeBot\\' => __DIR__ . '/src'
    ];
    foreach ($mapping as $prefix => $dir) {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            continue;
        }
        $relative_class = substr($class, $len);
        $file = $dir . '/' . str_replace('\\', '/', $relative_class) . '.php';

        if (file_exists($file)) {
            require $file;
            return true;
        }
    }
    return false;
});