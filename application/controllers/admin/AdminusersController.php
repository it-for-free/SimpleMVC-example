<?php
namespace application\controllers\admin;

use ItForFree\SimpleMVC\Config;
use \application\models\UserModel;

/**
 * Администрирование пользователей
 */
class AdminusersController extends BaseController
{
    /**
     * @var string Путь к файлу макета
     */
    public string $layoutPath = 'admin-main.php';

    /**
     * Определим соответствие роли пользователя и разрешённых для этой роли методов контроллера
     * Поддерживаются псевдонимы:
     * ? -- для пользователя с ролью как $guestRoleName (условный гость -- т.е. неавторизованный пользователь)
     * @ -- для пользователя с ролью НЕ как $guestRoleName (условно -- все остальные пользователи, авторизованные, не гости)
     *
     * @var array
     */
    protected array $rules = [ //вариант 2:  здесь всё гибче, проще развивать в дальнешем
         ['allow' => true, 'roles' => ['admin']],
         ['allow' => false, 'roles' => ['?', '@']],
    ];

    /**
     * Основное действие контроллера
     */
    public function indexAction()
    {
        $this->isAllow();

        $Url = Config::get('core.router.class');
        $Adminuser = new UserModel();

        // Если указан конктреный пользователь
        if (isset($_GET['id'])) {
            // Если URL-ссылка ведёт на страницу с несуществующим Id пользователя
            if (! $viewAdminuser = $Adminuser->getById((int)$_GET['id'])) {
                $this->redirect($Url::link("admin/adminusers/index&error=userNotFound"));
                return;
            }

            $results['pageTitle'] = "Show User";

            // вывод сообщения (если есть)
            if (isset($_GET['status'])) {
                if ($_GET['status'] == "changesSaved") {
                    $results['statusMessage'] = "Your changes have been saved.";
                }
            }

            // print_r($results);
            $this->view->addVar('viewAdminuser', $viewAdminuser);
            $this->view->addVar('results', $results);
            $this->view->render('user/view-item.php');
        }
        // Иначе выводим полный список пользователей
        else {
            $viewAdminusers = $Adminuser->getList();
            $results['users'] = $viewAdminusers['results'];
            $results['totalRows'] = $viewAdminusers['totalRows'];
            $results['pageTitle'] = "All users";

            // вывод сообщения об ошибке (если есть)
            if (isset($_GET['error'])) {
                if ($_GET['error'] == "userNotFound") {
                    $results['errorMessage'] = "Error: User not found.";
                }
            }

            // вывод сообщения (если есть)
            if (isset($_GET['status'])) {
                if ($_GET['status'] == "userAdded") {
                    $results['statusMessage'] = "New user have been added.";
                }
                if ($_GET['status'] == "userDeleted") {
                    $results['statusMessage'] = "User deleted.";
                }
            }

            //print_r($results);
            $this->view->addVar('results', $results);
            $this->view->render('user/index.php');
        }
    }

    /**
     * Создание нового пользователя
     */
    public function addAction()
    {
        $this->isAllow();

        $Url = Config::get('core.router.class');

        if (! empty($_POST)) {
            // Админ заполнил и отправил форму
            if (! empty($_POST['saveNewUser'])) {
                $Adminuser = new UserModel();
                $newAdminuser = $Adminuser->loadFromArray($_POST);
                $newAdminuser->insert(); 
                $this->redirect($Url::link("admin/adminusers/index&status=userAdded"));
            } 
            // Админ сбросил результаты заполнения формы: возвращаемся к списку пользователей
            elseif (! empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/adminusers/index"));
            }
        }
        // Админ ещё не получил форму создания нового пользователя
        else {
            $results['pageTitle'] = "New User";

            $this->view->addVar('results', $results);
            $this->view->render('user/add.php');
        }
    }

    /**
     * Редактирование пользователя
     */
    public function editAction()
    {
        $this->isAllow();

        $id = (int)$_GET['id'];
        $Url = Config::get('core.router.class');
        $Adminuser = new UserModel();

        // Если URL-ссылка ведёт на страницу с несуществующим Id пользователя
        if (isset($id) && ! $results['user'] = $Adminuser->getById($id)) {
            $this->redirect($Url::link("admin/adminusers/index&error=userNotFound"));
            return;
        }

        if (! empty($_POST)) {
            // Админ отредактировал и отправил форму
            if (! empty($_POST['saveChanges'] )) {
                $newAdminuser = $Adminuser->loadFromArray($_POST);
                $newAdminuser->update();
                $this->redirect($Url::link("admin/adminusers/index&id=$id&status=changesSaved"));
            }
            // Админ сотказался от результатов редактирования: возвращаемся к форме редактирования
            elseif (! empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/adminusers/index&id=$id"));
            }
        }
        // Админ ещё не получил форму редактирования пользователя
        else {
            $results['pageTitle'] = "Edit User";

            $this->view->addVar('results', $results);
            $this->view->render('user/edit.php');   
        }
    }

    /**
     * Удаление пользователя
     */
    public function deleteAction()
    {
        $this->isAllow();

        $id = (int)$_GET['id'];
        $Url = Config::get('core.router.class');
        $Adminuser = new UserModel();

        // Если URL-ссылка ведёт на страницу с несуществующим Id пользователя
        if (isset($id) && ! $deletedAdminuser = $Adminuser->getById($id)) {
            $this->redirect($Url::link("admin/adminusers/index&error=userNotFound"));
            return;
        }

        if (! empty($_POST)) {
            if (! empty($_POST['deleteUser'])) {
                $deletedAdminuser->delete();
                $this->redirect($Url::link("admin/adminusers/index&status=userDeleted"));
            }
            elseif (! empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/adminusers/edit&id=$id"));
            }
        }
        else {
            $results['pageTitle'] = "Delete User";
            $deleteAdminusersTitle = "Удаление пользователя";

            $this->view->addVar('results', $results);
            $this->view->addVar('deleteAdminusersTitle', $deleteAdminusersTitle);
            $this->view->addVar('deletedAdminusers', $deletedAdminuser);

            $this->view->render('user/delete.php');
        }
    }
}

