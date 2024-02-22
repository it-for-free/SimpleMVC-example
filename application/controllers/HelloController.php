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
}

