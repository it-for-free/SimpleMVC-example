<?php

require_once 'base_autoload.php';

function autoload($className) {
    $baseDir = __DIR__ . DIRECTORY_SEPARATOR;
    baseAutoload($className, $baseDir);
}

spl_autoload_register('autoload');

require_once __DIR__ . '/vendor/autoload.php';
