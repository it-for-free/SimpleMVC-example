<?php

$projectRoot = __DIR__;
require_once 'console_autoload.php';

$localConfig = require(__DIR__ . '/application/config/web-local.php');
$config = ItForFree\rusphp\PHP\ArrayLib\Merger::mergeRecursivelyWithReplace(
    require(__DIR__ . '/application/config/console.php'), 
    $localConfig);

\ItForFree\SimpleMVC\Application::get()
    ->setConfiguration($config)
    ->run();
