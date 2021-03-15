<?php


namespace app\controllers;


use app\models\User;
use core\base\Controller;

class UserController extends Controller
{
    /**
     * Регистрация пользователя
     */
    public function signupAction(): void
    {
        if (!empty($_POST)) {
            $login = htmlspecialchars(trim($_POST['login']));
            $name = htmlspecialchars(trim($_POST['name']));
            $email = $_POST['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('Email incorrect');
            }
            $user = new User();
            $user->load([
                'login' => $login,
                'password' => $_POST['password'],
                'name' => $name,
                'email' => $email
                ]);

            if ($user->checkExist()) {
                $user->getErrors();
            } else {
                $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
                try {
                    if (!$user->save('users')) {
                        throw new \Exception('Ошибка сохранения');
                    }
                    $_SESSION['success'] = 'Пользователь успешно зарегестрирован.';
                } catch (\Exception $e) {
                    $_SESSION['error'] = 'Ошибка сохранения';
                }
            }
            redirect();
        }
    }

    /**
     * Авторизация пользователя
     */
    public function loginAction(): void
    {
        if (!empty($_POST)) {
            $user = new User();
            if ($user->login()) {
                redirect('/');
            } else {
                $_SESSION['errors'] = 'Логин/пароль введен не верно.';
            }
            redirect();
        }
    }

    /**
     * Выход из системы
     */
    public function logoutAction(): void
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
        redirect();
    }
}