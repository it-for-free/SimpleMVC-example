<?php
namespace application\models;

use ItForFree\SimpleMVC\MVC\Model;

/**
 * Класс для обработки статей
 */
class ArticleModel extends Model
{
    /**
     * @var int ID статьи из базы данных
     */
    public ?int $id = null;

    /**
     * @var date Дата первой публикации статьи
     */
    public $publicationDate = null;

    /**
     * @var string Полное название статьи
     */
    public $title = null;

    /**
     * @var int|string ID категории статьи
     */
    public $categoryId = null;

    /**
     * @var int ID категории статьи, полученной из связанной таблицы по ID подкатегории
     */
    public $categoryId2 = null;

    /**
     * @var int ID подкатегории статьи
     */
    public $subcategoryId = null;

    /**
    * @var array Логин(ы) автора(ов) статьи
    */
    public $authors = array();

    /**
     * @var string Краткое описание статьи
     */
    public $summary = null;

    /**
     * @var string HTML содержание статьи
     */
    public $content = null;

    /**
     * @var int активность статьи (1 - статья активна, показывается на главной 
     * странице и странице архива; 0 - статья не активна, видит только админ)
     */
    public $active = null;

    /**
     * Создаст объект статьи
     * 
     * @param array $data массив значений (столбцов) строки таблицы статей
     */
    public function __construct($data = array())
    {
        if (isset($data['id'])) {
            $this->id = (int) $data['id'];
        }

        if (isset($data['publicationDate'])) {
            $this->publicationDate = (string) $data['publicationDate'];
        }
        // die(print_r($this->publicationDate));

        if (isset($data['title'])) {
            $this->title = $data['title'];
        }

        if (isset($data['categoryId'])) {
            $this->categoryId = $data['categoryId'];
        }

        if (isset($data['categoryId2'])) {
            $this->categoryId = $data['categoryId2'];
        }

        if (isset($data['subcategoryId'])) {
            $this->subcategoryId = (int) $data['subcategoryId'];
        }

        if (isset($data['authors'])) {
            $this->authors = $data['authors'];
        }

        if (isset($data['summary'])) {
            $this->summary = $data['summary'];
        }

        if (isset($data['content'])) {
            $this->content = $data['content'];
        }

        if (isset($data['active'])) {
            $this->active = (int) $data['active'];
        }
    }

    /**
     * @var string Критерий сортировки строк таблицы
     */
    public string $orderBy = 'id ASC';

    /**
     * @var string название таблицы
     */
    public string $tableName = 'articles';

    /**
     * Устанавливаем свойства с помощью значений формы редактирования записи в заданном массиве
     *
     * @param assoc Значения записи формы
     */
    public function storeFormValues($params)
    {
        // Сохраняем все параметры
        $this->__construct($params);

        // Разбираем и сохраняем дату публикации
        if (isset($params['publicationDate'])) {
            $publicationDate = explode('-', $params['publicationDate']);

            if (count($publicationDate) == 3) {
                list($y, $m, $d) = $publicationDate;
                $this->publicationDate = mktime(0, 0, 0, $m, $d, $y);
            }
        }
    }

    /**
     * Возвращает все (или диапазон) объекты Article из базы данных
     *
     * @param int $numRows Количество возвращаемых строк (по умолчанию = 1000000)
     * @param int $categoryId Вернуть статьи только из категории с указанным ID
     * @param string $order Столбец, по которому выполняется сортировка статей (по умолчанию = "publicationDate DESC")
     * @param int $getActive Вернуть ли только активные статьи (по умолчанию null, т.е. вернуть все статьи)
     * @return Array|false Двух элементный массив: results => массив объектов Article; totalRows => общее количество строк
     */
    public function getListCustom($numRows = 1000000,
            $categoryId = null, $subcategoryId = null, $order = null, $getActive = null)
    {
        // Делаем запрос к БД для отображения авторов статьи
        $sql = "SELECT user_articles.*, users.login, users.id AS userId
            FROM user_articles
            LEFT JOIN users
                ON user_articles.loginId = users.id";
        $st = $this->pdo->prepare($sql);
        $st->execute();

        // Сформируем массив вида ( [5]=>Array( [1]=>Masha [3]=>Vova ) [10]=>Array( [1]=>Masha ) )
        // каждым ключём которого будет ID статьи, а значением - массив авторов этой статьи
        $authors = array();
        while ($row = $st->fetch()) {
            // если такой ID статьи уже существует в массиве, просто добавим к статье ещё одного автора
            if (array_key_exists($row['articleId'], $authors)) {
                $authors[$row['articleId']][$row['userId']] = $row['login'];
            } else {
                $authors[$row['articleId']] = array($row['userId'] => $row['login']);
            }
        }
        
        $fromPart = "FROM " . $this->tableName;

        if ($categoryId) {
            $categoryClause = "WHERE ($this->tableName.categoryId = :categoryId OR subcategories.categoryId = :categoryId)";
        } elseif ($subcategoryId) {
            $categoryClause = "WHERE $this->tableName.subcategoryId = :subcategoryId";
        } else {
            $categoryClause = "";
        }

        $orderClause = $order ? $order : "publicationDate DESC";

        /**
         * если переменная $getActive не существует, то показать все записи
         * если в $getActive передано значение 0, то показать только неактивные записи
         * если в $getActive передано значение 1, то показать только активные записи
         */
        if (isset($getActive)) {
            $getActive === 0 ? $flag = 0 : $flag = 1;
            $categoryId || $subcategoryId ? $activeClause = "AND active = $flag" : $activeClause = "WHERE active = $flag";
        } else {
            $activeClause = "";
        }

        $sql = "SELECT $this->tableName.*,
                UNIX_TIMESTAMP(publicationDate) AS publicationDate,
                subcategories.categoryId AS categoryId2
            $fromPart
            LEFT JOIN subcategories
                ON $this->tableName.subcategoryId = subcategories.id
            $categoryClause $activeClause
            ORDER BY $orderClause LIMIT :numRows";

        $st = $this->pdo->prepare($sql);
        $st->bindValue(":numRows", $numRows, \PDO::PARAM_INT);
        /**
         * Можно использовать debugDumpParams() для отладки параметров, 
         * привязанных выше с помощью bind()
         * @see https://www.php.net/manual/ru/pdostatement.debugdumpparams.php
         */

        if ($categoryId) {
            $st->bindValue(":categoryId", $categoryId, \PDO::PARAM_INT);
        }
        if ($subcategoryId) {
            $st->bindValue(":subcategoryId", $subcategoryId, \PDO::PARAM_INT);
        }

        // выполняем запрос к базе данных
        $st->execute();

        $list = array();
        $i = 0;
        while ($row = $st->fetch()) {
            $article = new ArticleModel($row);
            // Если в сформированном ранее массиве существует элемент с ключём равным ID статьи,
            // "прицепим" к объекту статьи ещё одно свойство - массив авторов этой статьи
            if (isset($authors[$article->id])) {
                $article->authors = $authors[$article->id];
            }
            $list[] = $article;
            $i++;
        }

        return (array("articles" => $list, "totalRows" => $i));
    }

    /**
     * Возвращаем объект статьи соответствующий заданному ID статьи
     *
     * @param int ID статьи
     * @return Article|false Объект статьи или false, если запись не найдена или возникли проблемы
     */
    public function getByIdCustom($id)
    {
        // Делаем запрос к БД для отображения свойств статьи
        $sql = "SELECT *, UNIX_TIMESTAMP(publicationDate)
            AS publicationDate FROM $this->tableName WHERE id = :id";

        $st = $this->pdo->prepare($sql);
        $st->bindValue(":id", $id, \PDO::PARAM_INT);
        $st->execute();

        $row = $st->fetch();

        if ($row) {
            // Делаем запрос к БД для отображения авторов статьи
            $sql = "SELECT user_articles.*, users.login
                FROM user_articles
                LEFT JOIN users
                    ON user_articles.loginId = users.id
                WHERE articleId = :articleId";

            $st = $this->pdo->prepare($sql);
            $st->bindValue(":articleId", $id, \PDO::PARAM_INT);
            $st->execute();

            $authors = array();
            while ($row2 = $st->fetch()) {
                $authors[] = $row2['login'];
            }

            $article = new ArticleModel($row);
            $article->authors = $authors;
            return (array("article" => $article));
        }
    }

    /**
     * Вставляем текущий объект Article в базу данных и устанавливаем его свойство ID
     */
    public function insert()
    {
        // Есть уже у объекта статьи ID?
        if (! is_null($this->id)) {
            trigger_error("Article::insert(): "
                . "Attempt to insert an Article object"
                . "that already has its ID property set (to $this->id).", E_USER_ERROR);
        }

        // Вставляем статью
        $sql = "INSERT INTO articles (publicationDate, categoryId, subcategoryId, title, summary, content, active)
            VALUES (FROM_UNIXTIME(:publicationDate), :categoryId, :subcategoryId, :title, :summary, :content, :active)";

        $st = $this->pdo->prepare($sql);
        $st->bindValue(":publicationDate", $this->publicationDate, \PDO::PARAM_INT);
        /**
         * Если переденное из представления значение categoryId является числом,
         * значит статья принадлежит непосредственно какой-то категории минуя подкатегорию,
         * запишем это значение в БД в столбец "categoryId",
         * а значение subcategoryId для этой статьи будет отутствовать.
         * Иначе эта статья принадлежит какой-то подкатегории, запишем это значение в БД в столбец "subcategoryId",
         * а значение categoryId для этой статьи будет равно нулю.
         */
        if (is_numeric($this->categoryId)) {
            $st->bindValue(":categoryId", $this->categoryId, \PDO::PARAM_INT);
            $st->bindValue(":subcategoryId", NULL);
        } else {
            $st->bindValue(":categoryId", 0);
            $st->bindValue(":subcategoryId", str_replace('sub_', '', $this->categoryId), \PDO::PARAM_INT);
        }
        $st->bindValue(":title", $this->title, \PDO::PARAM_STR);
        $st->bindValue(":summary", $this->summary, \PDO::PARAM_STR);
        $st->bindValue(":content", $this->content, \PDO::PARAM_STR);
        $st->bindValue(":active", $this->active, \PDO::PARAM_INT);

        $st->execute();
        $this->id = $this->pdo->lastInsertId();
        $lastInsertId = $this->id;

        // Если выбран(ы) автор(ы), вставляем данные в таблицу связей
        foreach ($this->authors as $user){
            $sql = "INSERT INTO user_articles (loginId, articleId)
                VALUES (:loginId, :articleId)";
            $st = $this->pdo->prepare($sql);
            $st->bindValue(":loginId", $user, \PDO::PARAM_INT);
            $st->bindValue(":articleId", $lastInsertId, \PDO::PARAM_INT); 
            $st->execute();
        }
    }

    /**
     * Обновляем текущий объект Article в базе данных
     */
    public function update()
    {
        // Есть ли у объекта статьи ID?
        if (is_null($this->id)) {
            trigger_error("Article::update(): "
                . "Attempt to update an Article object "
                . "that does not have its ID property set.", E_USER_ERROR);
        }

        // Обновляем статью. Объявлем начало транзации
        $this->pdo->beginTransaction();

        $sql = "UPDATE articles SET publicationDate = FROM_UNIXTIME(:publicationDate),
            categoryId = :categoryId, subcategoryId = :subcategoryId, title = :title,
            summary = :summary, content = :content, active = :active WHERE id = :id";

        $st = $this->pdo->prepare($sql);
        $st->bindValue(":publicationDate", $this->publicationDate, \PDO::PARAM_INT);
        /*
         * Если переданное из представления значение categoryId является числом,
         * значит статья принадлежит непосредственно какой-то категории минуя подкатегорию,
         * запишем это значение в БД в столбец "categoryId",
         * а значение subcategoryId для этой статьи будет отутствовать.
         * Иначе эта статья принадлежит какой-то подкатегории, запишем это значение в БД в столбец "subcategoryId",
         * а значение categoryId для этой статьи будет равно нулю.
         */
        if (is_numeric($this->categoryId)) {
            $st->bindValue(":categoryId", $this->categoryId, \PDO::PARAM_INT);
            $st->bindValue(":subcategoryId", NULL);
        } else {
            $st->bindValue(":categoryId", 0);
            $st->bindValue(":subcategoryId", str_replace('sub_', '', $this->categoryId), \PDO::PARAM_INT);
        }
        $st->bindValue(":title", $this->title, \PDO::PARAM_STR);
        $st->bindValue(":summary", $this->summary, \PDO::PARAM_STR);
        $st->bindValue(":content", $this->content, \PDO::PARAM_STR);
        $st->bindValue(":active", $this->active, \PDO::PARAM_INT);
        $st->bindValue(":id", $this->id, \PDO::PARAM_INT);

        $st->execute();

        // код ниже отработает даже в том случае, если пользователь не изменил автора(ов) в селекте
        // сначала удаляем старые строки из таблицы связей
        $sql = "DELETE FROM user_articles WHERE articleId = :id";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":id", $this->id, \PDO::PARAM_INT);
        $st->execute();

        // затем сразу вставляем новые строки в таблицу связей (если выбран хотя бы один автор)
        foreach ($this->authors as $user) {
            $sql = "INSERT INTO user_articles (loginId, articleId)
                VALUES (:loginId, :articleId)";
            $st = $this->pdo->prepare($sql);
            $st->bindValue(":loginId", $user, \PDO::PARAM_INT);
            $st->bindValue(":articleId", $this->id, \PDO::PARAM_INT); 
            $st->execute();
        }

        // Закрываем транзакцию
        $this->pdo->commit();
    }
}

