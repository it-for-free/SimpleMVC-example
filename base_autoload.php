<?php

function baseAutoload($className, $baseDir) {
    $className = ltrim($className, '\\');
    $fileName = '';
    $fileName .= $baseDir;
    $namespace = '';

    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    //echo $fileName;
    require $fileName;
}