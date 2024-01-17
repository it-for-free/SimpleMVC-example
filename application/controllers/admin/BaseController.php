<?php
namespace application\controllers\admin;

use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Router\WebRouter;
use \application\models\UserModel;

class BaseController extends \ItForFree\SimpleMVC\MVC\Controller
{
    /**
     * Проверяет, действительно ли существует в БД текущий пользователь и активен ли его аккаунт
     * Если да, то код метода, в котором данная функция была вызвана, продолжает выполняться дальше
     * Если нет, то пользователя разлогинивает и перекидывает на страницу входа в админку
     */
    public function isAllow()
    {
        $User = Config::getObject('core.user.class');
        $Adminuser = new UserModel();

        // Узнаем, активен (не заблокирован) ли текущий пользователь
        $activeCurrentUser = $Adminuser->getActive($User->userName);

        // Выведем сообщение о блокировке если пользователь удалён или не активен
        if (! isset($activeCurrentUser) || $activeCurrentUser != 1) {
            $User->logout();
            $this->redirect(WebRouter::link("login/login&auth=blocked"));
        }
    }
}

