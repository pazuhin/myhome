<?php


namespace app\controllers\admin;


use app\models\User;
use core\base\Controller;

class AppController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        $user = new User();
        if (!$user->isAdmin() && $route['action'] != 'login') {
            redirect('/admin/user/login');
        }
    }
}