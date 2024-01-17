<?php
namespace application\controllers\admin;

use ItForFree\SimpleMVC\Config;
use \application\models\CategoryModel;
use \application\models\SubcategoryModel;
use \application\models\ArticleModel;

/* 
 * Класс для работы с категориями
 */
class SubcategoriesController extends BaseController
{
    /**
     * @var string Название страницы
     */
    public $homepageTitle = "Article Subcategories";

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
     * Выводит на экран список всех имеющихся подкатегорий
     */
    public function indexAction()
    {
        $this->isAllow();

        $Subcategory = new SubcategoryModel();

        // Получим список всех имеющихся подкатегорий
        $viewSubcategories = $Subcategory->getList();
        $viewSubcategories['subcategories'] = array();
        foreach ($viewSubcategories['results'] as $subcategory) {
            $viewSubcategories['subcategories'][$subcategory->id] = $subcategory;
        }

        $viewSubcategories['pageTitle'] = $this->homepageTitle;

        // вывод сообщения об ошибке (если есть)
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "subcategoryNotFound") {
                $viewSubcategories['errorMessage'] = "Error: Subcategory not found.";
            }
            if ($_GET['error'] == "subcategoryContainsArticles") {
                $viewSubcategories['errorMessage'] = "Error: Subcategory contains articles. "
                    . "Delete the articles, or assign them to another subcategory, "
                    . "before deleting this subcategory.";
            }
        }

        // вывод сообщения (если есть)
        if (isset($_GET['status'])) {
            if ($_GET['status'] == "changesSaved") {
                $viewSubcategories['statusMessage'] = "Your changes have been saved.";
            }
            if ($_GET['status'] == "subcategoryDeleted") {
                $viewSubcategories['statusMessage'] = "Subcategory deleted.";
            }
        }

        // print_r($viewSubcategories);
        $this->view->addVar('results', $viewSubcategories);
        $this->view->render('subcategory/listSubcategories.php');
    }

    /**
     * Выводит на экран форму для создания новой подкатегории (только для Администратора)
     */
    public function addAction()
    {
        $this->isAllow();

        $Url = Config::get('core.router.class');

        if (! empty($_POST)) {
            // User has posted the subcategory edit form: save the new subcategory
            if (! empty($_POST['saveChanges'])) {
                $Subcategory = new SubcategoryModel();
                $newSubcategory = $Subcategory->loadFromArray($_POST);
                $newSubcategory->insert(); 
                $this->redirect($Url::link("admin/subcategories/index&status=changesSaved"));
            } 
            // User has cancelled their edits: return to the subcategory list
            elseif (! empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/subcategories/index"));
            }
        }
        // User has not posted the subcategory edit form yet: display the form
        else {
            $results['subcategory'] = new SubcategoryModel();

            $Category = new CategoryModel();
            $viewCategories = $Category->getList();
            $results['categories'] = $viewCategories['results'];

            $results['pageTitle'] = "New Article Subcategory";
            $results['formAction'] = $Url::link("admin/subcategories/add");

            // print_r($results);
            $this->view->addVar('results', $results);
            $this->view->render('subcategory/addOrEdit.php');
        }
    }

    /**
     * Выводит на экран форму для редактирования подкатегории (только для Администратора)
     */
    public function editAction()
    {
        $this->isAllow();

        $id = (int)$_GET['id'];
        $Url = Config::get('core.router.class');
        $Subcategory = new SubcategoryModel();

        // Если URL-ссылка ведёт на страницу с несуществующим Id подкатегории
        if (isset($id) && ! $results['subcategory'] = $Subcategory->getById($id)) {
            $this->redirect($Url::link("admin/subcategories/index&error=subcategoryNotFound"));
            return;
        }

        if (! empty($_POST)) {
            // User has posted the subcategory edit form: save the subcategory changes
            if (! empty($_POST['saveChanges'])) {
                $newSubcategory = $Subcategory->loadFromArray($_POST);
                $newSubcategory->update(); 
                $this->redirect($Url::link("admin/subcategories/index&status=changesSaved"));
            } 
            // User has cancelled their edits: return to the subcategory list
            elseif (! empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/subcategories/index"));
            }
        }
        // User has not posted the subcategory edit form yet: display the form
        else {
            $Category = new CategoryModel();
            $viewCategories = $Category->getList();
            $results['categories'] = $viewCategories['results'];
            
            $results['pageTitle'] = "Edit Article Subcategory";
            $results['formAction'] = $Url::link("admin/subcategories/edit&id=$id");

            // print_r($results);
            $this->view->addVar('results', $results);
            $this->view->render('subcategory/addOrEdit.php');
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
        $Subcategory = new SubcategoryModel();

        // Если URL-ссылка ведёт на страницу с несуществующим Id подкатегории
        if (isset($id) && ! $deletedSubcategory = $Subcategory->getById($id)) {
            $this->redirect($Url::link("admin/subcategories/index&error=subcategoryNotFound"));
            return;
        }

        // Если удаляемая подкатегория содержит хотя бы одну статью, отменим удаление
        $Article = new ArticleModel();
        $viewArticles = $Article->getListCustom(1000000, null, $deletedSubcategory->id);
        if ($viewArticles['totalRows'] > 0) {
            $this->redirect($Url::link("admin/subcategories/index&error=subcategoryContainsArticles"));
            return;
        }

        $deletedSubcategory->delete();
        $this->redirect($Url::link("admin/subcategories/index&status=subcategoryDeleted"));
    }
}

