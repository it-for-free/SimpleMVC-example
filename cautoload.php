<?php

function autoload($className)
{   
    // базовая директория, которая является корнем автозагрузки консольного приложения
    $baseDir = __DIR__ . DIRECTORY_SEPARATOR;
    $className = ltrim($className, '\\');
    $fileName  = '';
    $fileName .= $baseDir;
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
  
    require $fileName;
}

// регистрируем функцию автозагрузки
spl_autoload_register('autoload'); 

require_once __DIR__ . '/vendor/autoload.php';