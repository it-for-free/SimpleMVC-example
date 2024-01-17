<?php
namespace application\models;

use ItForFree\SimpleMVC\MVC\Model;

/**
 * Класс для обработки пользователей
 */
class UserModel extends Model
{
    /**
     * @var int ID пользователя из базы данных
     */
    public ?int $id = null;

    /**
    * @var string логин пользователя
    */
    public $login = null;

    /**
    * @var string "соль" к паролю пользователя
    */
    public $salt = null;

    /**
    * @var string сам пароль пользователя
    */
    public $pass = null;

    /**
    * @var string роль пользователя
    */
    public $role = null;

    /**
    * @var string электронная почта пользователя
    */
    public $email = null;

    /**
     * @var date Дата регистрации пользователя или его последнего обновления
     */
    public $timestamp = null;

    /**
     * @var int Активность пользователя (1 - пользователь активен, может добавлять,
     * редактировать и удалять статьи и категории; 0 - пользователь заблокирован)
     */
    public $active = null;

    /**
     * @var string Критерий сортировки строк таблицы
     */
    public string $orderBy = 'login ASC';

    /**
     * @var string название таблицы
     */
    public string $tableName = 'users';

    /**
     * Вставляет текущий объект User в базу данных
     */
    public function insert()
    {
        $sql = "INSERT INTO $this->tableName (timestamp, login, salt, pass, role, email, active)
            VALUES (:timestamp, :login, :salt, :pass, :role, :email, :active)";
        $st = $this->pdo->prepare($sql);

        $st->bindValue(":timestamp", (new \DateTime('NOW'))->format('Y-m-d H:i:s'), \PDO::PARAM_STMT);
        $st->bindValue(":login", $this->login, \PDO::PARAM_STR);

        //Хеширование пароля
        $this->salt = rand(0,1000000);
        $st->bindValue(":salt", $this->salt, \PDO::PARAM_STR);
//        \DebugPrinter::debug($this->salt);

        $this->pass .= $this->salt;
        $hashPass = password_hash($this->pass, PASSWORD_BCRYPT);
//        \DebugPrinter::debug($hashPass);
        $st->bindValue(":pass", $hashPass, \PDO::PARAM_STR);

        $st->bindValue(":role", $this->role, \PDO::PARAM_STR);
        $st->bindValue(":email", $this->email, \PDO::PARAM_STR);
        $st->bindValue(":active", $this->active, \PDO::PARAM_INT);

        $st->execute();
        $this->id = $this->pdo->lastInsertId();
    }

    /**
     * Обновляет текущий объект User в базе данных
     */
    public function update()
    {
        $saltAndPass = "";
        if ($this->pass) {
            $saltAndPass = "salt=:salt, pass=:pass, ";
        }
        $sql = "UPDATE $this->tableName SET timestamp=:timestamp, login=:login,
            $saltAndPass role=:role, email=:email, active=:active WHERE id = :id";  
        $st = $this->pdo->prepare($sql);

        $st->bindValue(":timestamp", (new \DateTime('NOW'))->format('Y-m-d H:i:s'), \PDO::PARAM_STMT);
        $st->bindValue(":login", $this->login, \PDO::PARAM_STR);

        if ($this->pass) {
            // Хеширование пароля
            $this->salt = rand(0,1000000);
            $st->bindValue(":salt", $this->salt, \PDO::PARAM_STR);
            $this->pass .= $this->salt;
            $hashPass = password_hash($this->pass, PASSWORD_BCRYPT);
            $st->bindValue(":pass", $hashPass, \PDO::PARAM_STR);
        }

        $st->bindValue(":role", $this->role, \PDO::PARAM_STR);
        $st->bindValue(":email", $this->email, \PDO::PARAM_STR);
        $st->bindValue(":active", $this->active, \PDO::PARAM_STR);
        $st->bindValue(":id", $this->id, \PDO::PARAM_INT);

        $st->execute();
    }

    /**
     * Вернёт id пользователя
     *
     * @return ?int
     */
/*
    public function getId()
    {
        if ($this->userName !== 'guest') {
            $sql = "SELECT id FROM users where login = :userName";
            $st = $this->pdo->prepare($sql);
            $st->bindValue(":userName", $this->userName, \PDO::PARAM_STR);
            $st->execute();
            $row = $st->fetch();
            return $row['id'];
        } else {
            return null;
        }  
    }
*/
    /**
     * Проверка логина и пароля пользователя.
     */
    public function getAuthData($login): ?array {
	$sql = "SELECT salt, pass FROM $this->tableName WHERE login = :login";
	$st = $this->pdo->prepare($sql);
	$st->bindValue(":login", $login, \PDO::PARAM_STR);
	$st->execute();
	$authData = $st->fetch();
	return $authData ? $authData : null;
    }

    /**
     * Получаем роль пользователя.
     *
     * @param string Логин пользователя
     * @return array Свойство "role"
     */
    public function getRole($login): array {
	$sql = "SELECT role FROM $this->tableName WHERE login = :login";
	$st = $this->pdo->prepare($sql);
	$st->bindValue(":login", $login, \PDO::PARAM_STR);
	$st->execute();
	return $st->fetch();
    }

    /**
     * Получаем активность пользователя.
     *
     * @param string Логин пользователя
     * @return string|false Свойство "active" или false, если запись не была найдена или в случае другой ошибки
     */
    public function getActive($login) {
	$sql = "SELECT active FROM $this->tableName WHERE login = :login";
	$st = $this->pdo->prepare($sql);
	$st->bindValue(":login", $login, \PDO::PARAM_STR);
	$st->execute();
	$row = $st->fetch();
	if (! empty($row)) {
	    return $row[0];
	}
    }
}

