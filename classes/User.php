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
            $this->login = htmlspecialchars($data['login']);
        }
        if (isset($data['password'])) {
            $this->password = htmlspecialchars($data['password']);
        }
        if (isset($data['active'])) {
            $this->active = (int) $data['active'];
        } else {
            $this->active = 1;
        }

    }

    /**
     * Получение пользователя по его id из БД
     * @param int id идентификатор пользователя
     */
    static public function getById(int $id): User
    {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM users WHERE id = :id";
        $st = $conn->prepare($sql);
        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();

        $row = $st->fetch();
        $conn = null;

        if ($row) {
            return new User($row);
        }
    }

    /**
     * Получает пользователя по логину
     * @param string login логин пользователя
     */
    static public function getByLogin(string $login): User
    {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM users WHERE login = :login";
        $st = $conn->prepare($sql);
        $st->bindValue(":login", $login, PDO::PARAM_STR);
        $st->execute();

        $row = $st->fetch();
        $conn = null;

        if ($row) {
            return new User($row);
        }
    }

    /**
     * Возвращает список пользователй из БД
     * @param string order столбец по которому происходит сортировка (по умолчанию login)
     * @param int count количество возвращаемых пользователей (по умолчанию 20)
     */
    static public function getList(int $count=20, string $order='login'): array
    {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM users ORDER BY $order LIMIT $count";
        $st = $conn->prepare($sql);
        $st->execute();
        $list = [];
        while ($row = $st->fetch()) {
            $list[] = new User($row);
        }
        $sql = "SELECT COUNT(*) AS totalUsers FROM users";
        $st = $conn->prepare($sql);
        $st->execute();
        $totalRow = $st->fetch();
        $conn = null;
        return ['results'=>$list, 'totalRows'=>(int) $totalRow[0]];
    }

    /**
     * Вставляем текущий объект в базу данных и получаем его id
     */
    public function insert(): void
    {
        if (! is_null($this->id)) {
            trigger_error("Пользователь уже добавлен в базу данных", E_USER_ERROR);
        }
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "INSERT INTO users (login, password, active) VALUES (:login, :password, :active)";
        $st = $conn->prepare($sql);
        $st->bindValue(":login", $this->login, PDO::PARAM_STR);
        $st->bindValue(":password", $this->password, PDO::PARAM_STR);
        $st->bindValue(":active", $this->active, PDO::PARAM_INT);
        $st->execute();
        $this->id = $conn->lastInsertID();
        $conn = null;
    }

    /**
     * Обновляет базу данных из теукщего объекта
     */
    public function update(): void
    {
        if (is_null($this->id)) {
            trigger_error("Не указан id пользователя", E_USER_ERROR);
        }
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "UPDATE users SET login = :login, password = :password, active = :active WHERE id = :id";
        $st = $conn->prepare($sql);
        $st->bindValue(':id', $this->id, PDO::PARAM_INT);
        $st->bindValue(':login', $this->login, PDO::PARAM_STR);
        $st->bindValue(':password', $this->password, PDO::PARAM_STR);
        $st->bindValue(':active', $this->active, PDO::PARAM_INT);
        $conn = null;
        $st->execute();

    }

    /**
     * Удаление пользователя из базы данных
     */
    public function delete(): void
    {
        if (is_null($this->id)) {
            trigger_error("Не указан id пользователя", E_USER_ERROR);
        }
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "DELETE FROM users WHERE id = :id LIMIT 1";
        $st = $conn->prepare($sql);
        $st->bindValue(':id', $this->id, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }
}