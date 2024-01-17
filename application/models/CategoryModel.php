<?php
namespace application\models;

use ItForFree\SimpleMVC\MVC\Model;

/**
 * Класс для обработки категорий статей
 */
class CategoryModel extends Model
{
    /**
     * @var int ID категории из базы данных
     */
    public ?int $id = null;

    /**
     * @var string Название категории
     */
    public $name = null;

    /**
     * @var string Короткое описание категории
     */
    public $description = null;


    /**
    * Устанавливаем свойства объекта с использованием значений в передаваемом массиве
    *
    * @param assoc Значения свойств
    */
/*  public function __construct( $data=array() ) {
      if ( isset( $data['id'] ) ) $this->id = (int) $data['id'];
      if ( isset( $data['name'] ) ) $this->name = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['name'] );
      if ( isset( $data['description'] ) ) $this->description = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['description'] );
}*/
    public function __construct($data = array())
    {
        if (isset($data['id'])) {
            $this->id = (int) $data['id'];
        }

        if (isset($data['name'])) {
            $this->name = $data['name'];
        }

        if (isset($data['description'])) {
            $this->description = $data['description'];
        }
    }

    /**
     * @var string Критерий сортировки строк таблицы
     */
    public string $orderBy = 'id ASC';

    /**
     * @var string название таблицы
     */
    public string $tableName = 'categories';

    /**
     * Вставляем текущий объект Category в базу данных и устанавливаем его свойство ID
     */
    public function insert()
    {
        // У объекта Category уже есть ID?
        if (! is_null($this->id)) {
            trigger_error ("Category::insert(): "
                . "Attempt to insert a Category object"
                . "that already has its ID property set (to $this->id).", E_USER_ERROR );
        }

        // Вставляем категорию
        $sql = "INSERT INTO $this->tableName (name, description) VALUES (:name, :description)";

        $st = $this->pdo->prepare($sql);
        $st->bindValue(":name", $this->name, \PDO::PARAM_STR);
        $st->bindValue(":description", $this->description, \PDO::PARAM_STR);

        $st->execute();
        $this->id = $this->pdo->lastInsertId();
    }

    /**
     * Обновляем текущий объект Category в базе данных
     */
    public function update()
    {
        // У объекта Category есть ID?
        if (is_null($this->id)) {
            trigger_error ("Category::update(): "
                . "Attempt to update a Category object "
                . "that does not have its ID property set.", E_USER_ERROR );
        }

        // Обновляем категорию
        $sql = "UPDATE $this->tableName SET name = :name, description = :description WHERE id = :id";

        $st = $this->pdo->prepare($sql);
        $st->bindValue(":name", $this->name, \PDO::PARAM_STR);
        $st->bindValue(":description", $this->description, \PDO::PARAM_STR);
        $st->bindValue( ":id", $this->id, \PDO::PARAM_INT );

        $st->execute();
    }
}

