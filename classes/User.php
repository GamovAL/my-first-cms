<?php


/**
 * Класс для обработки пользователей
 */
class User
{
    /**
     * @var int id пользователя из БД
     */
    public $id = null;

    /**
     * @var string login имя пользователя из БД
     */
    public $login = null;

    /**
     * @var string password пароль пользователя из БД
     */
    public $password = null;

    /**
     * @var int active флаг активности пользователя
     */
    public $active = null;

    /**
     * User constructor.
     * @param array data массив полей из БД
     */
    public function __construct(array $data=[])
    {
        if (isset($data['id'])) {
            $this->id = (int) $data['id'];
        }
        if (isset($data['login'])) {
            $this->login = (string) $data['login'];
        }
        if (isset($data['password'])) {
            $this->password = (string) $data['password'];
        }
        if (isset($data['active'])) {
            $this->active = (int) $data['active'];
        }

    }

    /**
     * Получение пользователя по его id из БД
     * @param int id идентификатор пользователя
     */
    public function getById (int $id)
    {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM user WHERE id = :id";
        $st = $conn->prepare($sql);
        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();

        $row = $st->fetch();
        $conn = null;

        if ($row) {
            return new User($row);
        }
    }

}