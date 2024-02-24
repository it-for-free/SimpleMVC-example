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
        echo 1 + 2, PHP_EOL;
    }

    public function echoAction()
    {
        global $argv;
        echo 'Вы ввели команду: "' . $argv[1] . '"', PHP_EOL;
        if (count($argv) == 3) {
            echo 'Дополнительный аргумент: "' . $argv[2] . '"', PHP_EOL;
        }
    }
}
