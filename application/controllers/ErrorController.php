<?php
namespace application\controllers;

class ErrorController extends \ItForFree\SimpleMVC\MVC\Controller
{
    public function indexAction($exception)
    {
        
        $this->view->addVar('status', $exception->getCode());
        $this->view->addVar('exception', $exception);
        $this->view->addVar('trace', $exception->getTrace());
        $this->view->addVar('message', $exception->getMessage());
        $this->view->render('error.php');
    }
}
