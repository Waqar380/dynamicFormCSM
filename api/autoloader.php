<?php

function autoload($className) {
    $className = str_replace('\\', '/', $className);
    $className=explode('/',$className);
    $className = end($className);

    $baseDirs = [__DIR__ . '\controllers', __DIR__ . '\models', __DIR__ . '\traits'];

    foreach ($baseDirs as $baseDir) {
        $filePath = $baseDir . $className . '.php';

        if (file_exists($filePath)) {
            require_once $filePath;
            return;
        }
    }
}

// Register autoloader function
spl_autoload_register('autoload');