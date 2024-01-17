<?php
namespace application\controllers\admin;

use ItForFree\SimpleMVC\Config;
use \application\models\UserModel;
use \application\models\ArticleModel;
use \application\models\CategoryModel;
use \application\models\SubcategoryModel;

/* 
 * Class-controller articles
 */
class ArticlesController extends BaseController
{
    /**
     * @var string Название страницы
     */
    public $homepageTitle = "All articles";

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
        // ['allow' => true, 'roles' => ['@'], 'actions' => ['index']],
        ['allow' => true, 'roles' => ['@']],
        ['allow' => false, 'roles' => ['?']],
    ];

    /**
     * Выводит на экран список всех имеющихся статей
     */
    public function indexAction()
    {
        $this->isAllow();

        $Article = new ArticleModel();
        $viewArticles = $Article->getListCustom(100000, null, null, null, 1);

        // Получим список всех имеющихся категорий
        $Category = new CategoryModel();
        $viewCategories = $Category->getList();
        $viewArticles['categories'] = array();
        foreach ($viewCategories['results'] as $category) {
            $viewArticles['categories'][$category->id] = $category;
        }

        // А так же список всех имеющихся подкатегорий
        $Subcategory = new SubcategoryModel();
        $viewSubcategories = $Subcategory->getList();
        $viewArticles['subcategories'] = array();
        foreach ($viewSubcategories['results'] as $subcategory) {
            $viewArticles['subcategories'][$subcategory->id] = $subcategory;
        }

        $viewArticles['pageHeading'] = $this->homepageTitle;
        $viewArticles['pageTitle'] = "Простая CMS на PHP";
        
        // вывод сообщения об ошибке (если есть)
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "articleNotFound") 
                $viewArticles['errorMessage'] = "Error: Article not found.";
        }

        // вывод сообщения (если есть)
        if (isset($_GET['status'])) {
            if ($_GET['status'] == "changesSaved") {
                $viewArticles['statusMessage'] = "Your changes have been saved.";
            }
            if ($_GET['status'] == "articleDeleted")  {
                $viewArticles['statusMessage'] = "Article deleted.";
            }
        }
        
        // print_r($viewArticles);
        $this->view->addVar('results', $viewArticles);
        $this->view->render('article/listArticles.php');
    }

    /**
     * Выводит на экран форму для создания новой статьи (только для Администратора)
     */
    public function addAction()
    {
        $this->isAllow();

        $Url = Config::get('core.router.class');

        if (! empty($_POST)) {
            // Пользователь заполнил и отправил форму
            if (! empty($_POST['saveChanges'])) {
                $Article = new ArticleModel();
                $Article->storeFormValues($_POST);
                $Article->insert(); 
                $this->redirect($Url::link("admin/articles/index&status=changesSaved"));
            }
            // Пользователь сбросил результаты заполнения формы: возвращаемся к списку статей
            elseif (! empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/articles/index"));
            }
        }
        // Пользователь еще не получил форму редактирования: выводим форму
        else {
            $Category = new CategoryModel();
            $viewCategories = $Category->getList();
            $results['categories'] = $viewCategories['results'];

            $Subcategory = new SubcategoryModel();
            $viewSubcategories = $Subcategory->getList();
            $results['subcategories'] = $viewSubcategories['results'];

            $User = new UserModel;
            $viewUsers = $User->getList();
            $results['users'] = $viewUsers['results'];

            // Для корректной работы представления отправим в него экземпляр Article с пустыми свойствами
            $results['article'] = new ArticleModel();

            $results['pageTitle'] = "New Article";
            $results['formAction'] = $Url::link("admin/articles/add");

            // print_r($results);
            $this->view->addVar('results', $results);
            $this->view->render('article/addOrEdit.php');
        }
    }

    /**
     * Выводит на экран форму для редактирования статьи (только для Администратора)
     */
    public function editAction()
    {
        $this->isAllow();

        $id = (int)$_GET['id'];
        $Url = Config::get('core.router.class');
        $Article = new ArticleModel();

        // Если URL-ссылка ведёт на страницу с несуществующим Id статьи
        if (isset($id) && ! $results = $Article->getByIdCustom($id)) {
            $this->redirect($Url::link("admin/articles/index&error=articleNotFound"));
            return;
        }

        if (! empty($_POST)) {
            // Пользователь отредактировал и отправил форму
            if (! empty($_POST['saveChanges'])) {
                $Article->storeFormValues($_POST);
                $Article->update();
                $this->redirect($Url::link("admin/articles/index&status=changesSaved"));
            } 
            // Пользователь отказался от результатов редактирования: возвращаемся к списку статей
            elseif (! empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/articles/index"));
            }
        }
        // Пользователь еще не получил форму редактирования: выводим форму
        else {
            $Category = new CategoryModel();
            $viewCategories = $Category->getList();
            $results['categories'] = $viewCategories['results'];

            $Subcategory = new SubcategoryModel();
            $viewSubcategories = $Subcategory->getList();
            $results['subcategories'] = $viewSubcategories['results'];

            $User = new UserModel;
            $viewUsers = $User->getList();
            $results['users'] = $viewUsers['results'];

            $results['pageTitle'] = "Edit Article";
            $results['formAction'] = $Url::link("admin/articles/edit&id=$id");

            // print_r($results);
            $this->view->addVar('results', $results);
            $this->view->render('article/addOrEdit.php');
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
        $Article = new ArticleModel();

        // Если URL-ссылка ведёт на страницу с несуществующим Id статьи
        if (isset($id) && ! $deletedArticle = $Article->getById($id)) {
            $this->redirect($Url::link("admin/articles/index&error=articleNotFound"));
            return;
        }

        $deletedArticle->delete();
        $this->redirect($Url::link("admin/articles/index&status=articleDeleted"));
    }
}

