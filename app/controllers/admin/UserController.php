<?php


namespace app\controllers\admin;


use app\models\User;

class UserController extends AppController
{
    /**
     * Авторизация с дополнительной проверкой роли
     */
    public function loginAction()
    {
        if (!empty($_POST)) {
            $user = new User();
            if ($user->login(true)) {
                $_SESSION['success'] = 'Вы успешно зарегистрированы';
            } else {
                $_SESSION['errors'] = 'Логин/пароль введены не верно';
            }

            if ($user->isAdmin()) {
                redirect('/admin');
            } else {
                redirect();
            }
        }
    }
}