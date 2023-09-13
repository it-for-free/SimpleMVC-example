<?php
namespace application\handlers;

use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Interfaces\ExceptionHandlerInterface;

/**
 * Пример пользовательского класса для перехвата исключений
 */
class UserExceptionHandler implements ExceptionHandlerInterface
{
    public function handleException(\Exception $exception): void
    {
        $this->displayException($exception);
    }

    public function displayException($exception)
    {   
        $route = "error/";
        $Router = Config::getObject('core.router.class');
        $Router->callControllerAction($route, $exception);        
    }
}