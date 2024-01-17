<?php

namespace application\controllers;

/**
 * Контроллер для проверки работоспособности консольного приложения
 */
class HelloController extends \ItForFree\SimpleMVC\MVC\Controller
{
    public function indexAction()
    {
        echo 'HELLO !', PHP_EOL;
    }
}

