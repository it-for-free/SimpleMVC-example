<?php
namespace application\models;

use ItForFree\SimpleMVC\MVC\Model;

/**
 * Класс для обработки подкатегорий статей
 */
class SubcategoryModel extends Model
{
    /**
     * @var int ID подкатегории из базы данных
     */
    public ?int $id = null;

    /**
     * @var int ID категории, к которой относится данная подкатегория
     */
    public $categoryId = null;

    /**
     * @var string Название категории, к которой относится данная подкатегория (будет взято из связанной таблицы)
     */
    public $name = null;

    /**
     * @var string Название подкатегории
     */
    public $subname = null;

    /**
     * Устанавливаем свойства объекта с использованием значений в передаваемом массиве
     *
     * @param assoc Значения свойств
     */
    public function __construct($data = array())
    {
        if (isset($data['id'])) {
            $this->id = (int) $data['id'];
        }

        if (isset($data['categoryId'])) {
            $this->categoryId = (int) $data['categoryId'];
        }

        if (isset($data['name'])) {
            $this->name = $data['name'];
        }

        if (isset($data['subname'])) {
            $this->subname = $data['subname'];
        }
    }

    /**
     * @var string Критерий сортировки строк таблицы
     */
    public string $orderBy = 'id ASC';

    /**
     * @var string название таблицы
     */
    public string $tableName = 'subcategories';

    /**
     * Вставляем текущий объект Subcategory в базу данных и устанавливаем его свойство ID
     */
    public function insert()
    {
        // У объекта Subcategory уже есть ID?
        if (! is_null($this->id)) {
            trigger_error ("Subcategory::insert(): "
                . "Attempt to insert a Subcategory object "
                . "that already has its ID property set (to $this->id).", E_USER_ERROR);
        }

        // Вставляем подкатегорию
        $sql = "INSERT INTO $this->tableName (categoryId, subname) VALUES (:categoryId, :subname)";

        $st = $this->pdo->prepare($sql);
        $st->bindValue(":categoryId", $this->categoryId, \PDO::PARAM_INT);
        $st->bindValue(":subname", $this->subname, \PDO::PARAM_STR);

        $st->execute();
        $this->id = $this->pdo->lastInsertId();
    }

    /**
     * Обновляем текущий объект Subcategory в базе данных
     */
    public function update() {

        // У объекта Subcategory есть ID?
        if (is_null($this->id)) {
            trigger_error ("Subcategory::update(): "
                . "Attempt to update a Subcategory object "
                . "that does not have its ID property set.", E_USER_ERROR);
        }

        // Обновляем подкатегорию
        $sql = "UPDATE $this->tableName SET categoryId = :categoryId, subname = :subname WHERE id = :id";

        $st = $this->pdo->prepare($sql);
        $st->bindValue(":categoryId", $this->categoryId, \PDO::PARAM_STR);
        $st->bindValue(":subname", $this->subname, \PDO::PARAM_STR);
        $st->bindValue( ":id", $this->id, \PDO::PARAM_INT );

        $st->execute();
    }
}

