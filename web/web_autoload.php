<?php
use ItForFree\rusphp\File\Path;

require_once '../base_autoload.php';

function autoload($className)
{
    $baseDir = Path::addToDocumentRoot('..' . DIRECTORY_SEPARATOR);
    baseAutoload($className, $baseDir);
}

// регистрируем функцию автозагрузки
spl_autoload_register('autoload'); 

require_once __DIR__ . '/../vendor/autoload.php';