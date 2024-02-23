<?php

namespace application\controllers;

/**
 * Контроллер для проверки работоспособности консольного приложения
 */
class HelloController
{
    public function indexAction()
    {
        echo 'HELLO !', PHP_EOL;
    }

    public function calcAction()
    {
        global $argv;
        echo 'Вы ввели команду: "' . $argv[1] . '"', PHP_EOL;
        echo 1 + 2, PHP_EOL;
    }
}

