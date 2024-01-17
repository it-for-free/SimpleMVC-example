<?php
namespace application\controllers;

use ItForFree\SimpleMVC\Config;
use \application\models\ArticleModel;
use \application\models\CategoryModel;
use \application\models\SubcategoryModel;

define("HOMEPAGE_NUM_ARTICLES", 5);

/**
 * Контроллер для клиентской (не администраторской) части приложения
 */
class HomepageController extends \ItForFree\SimpleMVC\MVC\Controller
{
    /**
     * @var string Название страницы
     */
    public $homepageTitle = "Домашняя страница";

    /**
     * @var string Путь к файлу макета 
     */
    public string $layoutPath = 'main.php';

    /**
     * Вывод домашней ("главной") страницы сайта
     */
    public function indexAction()
    {
        $Articles = new ArticleModel();
        $Categories = new CategoryModel();
        $Subcategories = new SubcategoryModel();

        $viewArticles = $Articles->getListCustom(HOMEPAGE_NUM_ARTICLES, null, null, null, 1);

        // Получим список всех имеющихся категорий
        $viewCategories = $Categories->getList();
        $viewArticles['categories'] = array();
        foreach ($viewCategories['results'] as $category) {
            $viewArticles['categories'][$category->id] = $category;
        }

        // А так же список всех имеющихся подкатегорий
        $viewSubcategories = $Subcategories->getList();
        $viewArticles['subcategories'] = array();
        foreach ($viewSubcategories['results'] as $subcategory) {
            $viewArticles['subcategories'][$subcategory->id] = $subcategory;
        }

        $viewArticles['pageHeading'] = $this->homepageTitle;
        $viewArticles['pageTitle'] = "Простая CMS на PHP";

        // print_r($viewArticles);
        $this->view->addVar('results', $viewArticles);
        $this->view->render('homepage/index.php');
    }

    /**
     * Вывод какого-то варианта архивной страницы сайта
     */
    public function archiveAction()
    {
        $Articles = new ArticleModel();
        $Categories = new CategoryModel();
        $Subcategories = new SubcategoryModel();

        $results['category'] = null;
        $results['subcategory'] = null;

        // Если клиент захочет посмотреть все статьи из какой-то конкретной категории или подкатегории
        if (isset($_GET['categoryId']) && $_GET['categoryId']) {
            $categoryId = (int)$_GET['categoryId'];

            // Если URL-ссылка ведёт на страницу с несуществующим Id категории
            if (! $results['category'] = $Categories->getById($categoryId)) {
                $results['errorMessage'] = "Категория с id = $categoryId не найдена";
                $this->view->addVar('results', $results);
                $this->view->render('error.php');
                return;
            }
        }
        if (isset($_GET['subcategoryId']) && $_GET['subcategoryId']) {
            $subcategoryId = (int)$_GET['subcategoryId'];

            // Если URL-ссылка ведёт на страницу с несуществующим Id подкатегории
            if (! $results['subcategory'] = $Subcategories->getById($subcategoryId)) {
                $results['errorMessage'] = "Подкатегория с id = $subcategoryId не найдена";
                $this->view->addVar('results', $results);
                $this->view->render('error.php');
                return;
            }
        }

        $viewArticles = $Articles->getListCustom(
            100000,
            $results['category'] ? $results['category']->id : null,
            $results['subcategory'] ? $results['subcategory']->id : null,
            null,
            1
        );

        // Получим список всех имеющихся категорий
        $viewCategories = $Categories->getList();
        $viewArticles['categories'] = array();
        foreach ($viewCategories['results'] as $category) {
            $viewArticles['categories'][$category->id] = $category;
        }

        // А так же список всех имеющихся подкатегорий
        $viewSubcategories = $Subcategories->getList();
        $viewArticles['subcategories'] = array();
        foreach ($viewSubcategories['results'] as $subcategory) {
            $viewArticles['subcategories'][$subcategory->id] = $subcategory;
        }

        /**
         * Зададим заголовок страницы
         * Плюс если клиент захочет посмотреть все статьи из какой-то конкретной категории или подкатегории,
         * дополнительно отправим ему в представление информацию об этой категории или подкатегории
         */
        if (isset($results['category'])) {
            $viewArticles['category'] = $results['category'];
            $viewArticles['pageHeading'] = $results['category']->name;
        }
        elseif (isset($results['subcategory'])) {
            $viewArticles['subcategory'] = $results['subcategory'];
            $viewArticles['pageHeading'] = $results['subcategory']->subname;
        }
        else {
            $viewArticles['pageHeading'] = "Article Archive";
        }
 
        $viewArticles['pageTitle'] = $viewArticles['pageHeading'] . " | Widget News";

        // print_r($viewArticles);
        $this->view->addVar('results', $viewArticles);
        $this->view->render('homepage/archive.php');
    }

    /**
     * Вывод страницы с конкретной статьёй
     */
    public function viewArticleAction()
    {
        if (! isset($_GET['articleId']) || ! $_GET['articleId']) {
            $this->indexAction();
            return;
        }

        $Article = new ArticleModel();
        $Categories = new CategoryModel();
        $Subcategories = new SubcategoryModel();

        $articleId = (int)$_GET['articleId'];

        // Если URL-ссылка ведёт на страницу с несуществующим Id статьи
        if (! $viewArticle = $Article->getByIdCustom($articleId)) {
            $viewArticle['errorMessage'] = "Статья с id = $articleId не найдена";
            $this->view->addVar('results', $viewArticle);
            $this->view->render('error.php');
            return;
        }
/*
        if (! isset($viewArticle)) {
            throw new Exception("Статья с id = $articleId не найдена");
        }
*/

        // Если статья относится к какой-нибудь категории и/или подкатегории, выведем инфу о ней
        if ($viewArticle['article']->categoryId) {
            $categoryId = (int)$viewArticle['article']->categoryId;
            $viewArticle['category'] = $Categories->getById($categoryId);
        }
        if ($viewArticle['article']->subcategoryId) {
            $subcategoryId = (int)$viewArticle['article']->subcategoryId;
            $viewArticle['subcategory'] = $Subcategories->getById($subcategoryId);
        }
        
        $viewArticle['pageHeading'] = $viewArticle['article']->title;
        $viewArticle['pageTitle'] = $viewArticle['pageHeading'] . " | Простая CMS";

        // print_r($viewArticle);
        $this->view->addVar('results', $viewArticle);
        $this->view->render('homepage/viewArticle.php');
    }
}

