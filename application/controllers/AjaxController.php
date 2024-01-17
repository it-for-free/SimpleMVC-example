<?php
namespace application\controllers;

use ItForFree\SimpleMVC\Config;
use \application\models\ArticleModel;

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

    /**
     * Подгрузка полного текста статьи
     */
    public function showAction()
    {
        if (isset($_GET['articleId'])) {
            $Articles = new ArticleModel();
            $article = $Articles->getById((int)$_GET['articleId']);
            echo $article->content;
        }

        if (isset($_POST['articleId'])) {
            $Articles = new ArticleModel();
            $article = $Articles->getById((int)$_POST['articleId']);
            echo json_encode($article->content);
        }
    }   
}

