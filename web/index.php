<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('web_autoload.php'); // автозагрузка классов

$localConfig = require(__DIR__ . '/../application/config/web-local.php');
$config = ItForFree\rusphp\PHP\ArrayLib\Merger::mergeRecursivelyWithReplace(
    require(__DIR__ . '/../application/config/web.php'), 
    $localConfig);

require_once("../application/bootstrap.php");

\ItForFree\SimpleMVC\Application::get()
    ->setConfiguration($config)
    ->run();

