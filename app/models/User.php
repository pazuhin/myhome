<?php


namespace app\models;


use core\base\Model;
use core\DBCriteria;

class User extends Model
{
    public $pdo;
    public $attributes = [
        'login' => '',
        'password' => '',
        'name' => '',
        'email' => '',
        'role' => 'user'
    ];

    public function __construct()
    {
        $this->pdo = DBCriteria::instance();
    }

    public function checkExist()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users where login=:login or email=:email");
        $stmt->execute([':login' => $this->attributes['login'], ':email' => $this->attributes['email']]);

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($user) {
            if ($user['login'] === $this->attributes['login']) {
                $this->errors['unique'][] = 'Пользователь с таким login уже существует';
            }
            if ($user['email'] === $this->attributes['email']) {
                $this->errors['unique'][] = 'Пользователь с таким email уже существует';
            }
            return true;
        }
        return false;
    }

    public function login($isAdmin = false)
    {
        $login = !empty($_POST['login']) ? trim($_POST['login']) : null;
        $pass = !empty($_POST['password']) ? trim($_POST['password']) : null;

        if ($login && $pass) {
            if ($isAdmin) {
                $stmt = $this->pdo->prepare("SELECT * FROM users where login=:login and role = 'admin'");
                $stmt->execute([':login' => $login]);
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);
            } else {
                $stmt = $this->pdo->prepare("SELECT * FROM users where login=:login");
                $stmt->execute([':login' => $login]);
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);
            }
            if ($user) {
                if (password_verify($pass, $user['password'])) {
                    foreach ($user as $key => $value) {
                        if ($key != 'password') {
                            $_SESSION['user'][$key] = $value;
                        }
                    }
                    return true;
                }
            }
        }

        return false;
    }

    public static function checkAuth()
    {
        return isset($_SESSION['user']);
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin');
    }

    /**
     * @param string $table
     */
    public function save(string $table)
    {
        $sql = 'INSERT INTO '. $table . ' (login, password, email, name, role) VALUES (:login, :password, :email, :name, :role)';
        $stmt= $this->pdo->prepare($sql);
        $stmt->execute([
            ':login' => $this->attributes['login'],
            ':password' => $this->attributes['password'],
            ':email' => $this->attributes['email'],
            ':name' => $this->attributes['name'],
            ':role' => $this->attributes['role'],
        ]);

        return true;
    }
}