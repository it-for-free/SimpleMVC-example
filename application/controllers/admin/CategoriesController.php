<?php
namespace application\controllers\admin;

use ItForFree\SimpleMVC\Config;
use \application\models\CategoryModel;
use \application\models\ArticleModel;

/* 
 * Класс для работы с категориями
 */
class CategoriesController extends BaseController
{
    /**
     * @var string Название страницы
     */
    public $homepageTitle = "Article Categories";

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
    protected array $rules = [
        ['allow' => true, 'roles' => ['@']],
        ['allow' => false, 'roles' => ['?']],
    ];

    /**
     * Выводит на экран список всех имеющихся категорий
     */
    public function indexAction()
    {
        $this->isAllow();

        $Category = new CategoryModel();

        // Получим список всех имеющихся категорий
        $viewCategories = $Category->getList();
        $viewCategories['categories'] = array();
        foreach ($viewCategories['results'] as $category) {
            $viewCategories['categories'][$category->id] = $category;
        }

        $viewCategories['pageTitle'] = $this->homepageTitle;

        // вывод сообщения об ошибке (если есть)
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "categoryNotFound") {
                $viewCategories['errorMessage'] = "Error: Category not found.";
            }
            if ($_GET['error'] == "categoryContainsArticles") {
                $viewCategories['errorMessage'] = "Error: Category contains articles. "
                    . "Delete the articles, or assign them to another category, "
                    . "before deleting this category.";
            }
        }

        // вывод сообщения (если есть)
        if (isset($_GET['status'])) {
            if ($_GET['status'] == "changesSaved") {
                $viewCategories['statusMessage'] = "Your changes have been saved.";
            }
            if ($_GET['status'] == "categoryDeleted") {
                $viewCategories['statusMessage'] = "Category deleted.";
            }
        }

        // print_r($viewCategories);
        $this->view->addVar('results', $viewCategories);
        $this->view->render('category/listCategories.php');
    }

    /**
     * Выводит на экран форму для создания новой категории (только для Администратора)
     */
    public function addAction()
    {
        $this->isAllow();

        $Url = Config::get('core.router.class');

        if (! empty($_POST)) {
            // User has posted the category edit form: save the new category
            if (! empty($_POST['saveChanges'])) {
                $Category = new CategoryModel();
                $newCategory = $Category->loadFromArray($_POST);
                $newCategory->insert(); 
                $this->redirect($Url::link("admin/categories/index&status=changesSaved"));
            } 
            // User has cancelled their edits: return to the category list
            elseif (! empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/categories/index"));
            }
        }
        // User has not posted the category edit form yet: display the form
        else {
            $results['category'] = new CategoryModel();

            $results['pageTitle'] = "New Article Category";
            $results['formAction'] = $Url::link("admin/categories/add");

            // print_r($results);
            $this->view->addVar('results', $results);
            $this->view->render('category/addOrEdit.php');
        }
    }

    /**
     * Выводит на экран форму для редактирования категории (только для Администратора)
     */
    public function editAction()
    {
        $this->isAllow();

        $id = (int)$_GET['id'];
        $Url = Config::get('core.router.class');
        $Category = new CategoryModel();

        // Если URL-ссылка ведёт на страницу с несуществующим Id категории
        if (isset($id) && ! $results['category'] = $Category->getById($id)) {
            $this->redirect($Url::link("admin/categories/index&error=categoryNotFound"));
            return;
        }

        if (! empty($_POST)) {
            // User has posted the category edit form: save the category changes
            if (! empty($_POST['saveChanges'])) {
                $newCategory = $Category->loadFromArray($_POST);
                $newCategory->update();
                $this->redirect($Url::link("admin/categories/index&status=changesSaved"));
            } 
            // User has cancelled their edits: return to the category list
            elseif (! empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/categories/index"));
            }
        }
        // User has not posted the category edit form yet: display the form
        else {
            $results['pageTitle'] = "Edit Article Category";
            $results['formAction'] = $Url::link("admin/categories/edit&id=$id");

            // print_r($results);
            $this->view->addVar('results', $results);
            $this->view->render('category/addOrEdit.php');
        }
    }

    /**
     * Выводит на экран предупреждение об удалении данных (только для Администратора)
     */
    public function deleteAction()
    {
        $this->isAllow();

        $id = (int)$_GET['id'];
        $Url = Config::get('core.router.class');
        $Category = new CategoryModel();

        // Если URL-ссылка ведёт на страницу с несуществующим Id категории
        if (isset($id) && ! $deletedCategory = $Category->getById($id)) {
            $this->redirect($Url::link("admin/categories/index&error=categoryNotFound"));
            return;
        }

        // Если удаляемая категория содержит хотя бы одну статью, отменим удаление
        $Article = new ArticleModel();
        $viewArticles = $Article->getListCustom(1000000, $deletedCategory->id);
        if ($viewArticles['totalRows'] > 0) {
            $this->redirect($Url::link("admin/categories/index&error=categoryContainsArticles"));
            return;
        }

        $deletedCategory->delete();
        $this->redirect($Url::link("admin/categories/index&status=categoryDeleted"));
    }
}

