<?php
namespace application\controllers;

use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Router\WebRouter;
use \application\models\UserModel;

class LoginController extends \ItForFree\SimpleMVC\MVC\Controller
{
    /**
     * {@inheritDoc}
     */
    public string $layoutPath = 'main.php';

    /**
     * @var string Тайтл страницы
     */
    public $pageTitle = "Admin Login | Widget News";

    /**
     * Определим соответствие роли пользователя и разрешённых для этой роли методов контроллера
     * Поддерживаются псевдонимы:
     * ? -- для пользователя с ролью как $guestRoleName (условный гость -- т.е. неавторизованный пользователь)
     * @ -- для пользователя с ролью НЕ как $guestRoleName (условно -- все остальные пользователи, авторизованные, не гости)
     *
     * @var array
     */
    protected array $rules = [
        ['allow' => true, 'roles' => ['?'], 'actions' => ['login']],
        ['allow' => true, 'roles' => ['@'], 'actions' => ['logout']],
    ];

    /**
     * Вход в систему / Выводит на экран форму для входа в систему
     */
    public function loginAction()
    {
        if (! empty($_POST)) {
            $login = $_POST['userName'];
            $pass = $_POST['password'];

            // Узнаем, активен (не заблокирован) ли пользователь c введённым в форму логином
            $Adminuser = new UserModel();
            $activeAdminuser = $Adminuser->getActive($_POST['userName']);
            // print_r($activeAdminuser);
            if (isset($activeAdminuser) && $activeAdminuser != 1) {
                // Выведем сообщение о блокировке если пользователь существует и при этом не активен
                $this->redirect(WebRouter::link("login/login&auth=blocked"));
                return;
            }

            // Если активен или не существует такого пользователя, двигаемся дальше
            $User = Config::getObject('core.user.class');
            if ($User->login($login, $pass)) {
                $this->redirect(WebRouter::link("admin/articles/index"));
            }
            else {
                $this->redirect(WebRouter::link("login/login&auth=deny"));
            }
        }
        else {
            $results['pageTitle'] = $this->pageTitle;
            $this->view->addVar('results', $results);
            $this->view->render('login/index.php');
        }
    }

    /**
     * Выход из системы
     */
    public function logoutAction()
    {
        $User = Config::getObject('core.user.class');
        $User->logout();
        $this->redirect(WebRouter::link("login/login"));
    }
}

