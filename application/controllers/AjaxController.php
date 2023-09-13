<?php
namespace application\controllers;

/**
 * Можно использовать для обработки ajax-запросов.
 */
class AjaxController extends \ItForFree\SimpleMVC\MVC\Controller 
{
    /**
     * Подгрузка "лайков" статей или товаров
     */
    public function likeAction()
    {
       echo 'привет!';
    }   
}

