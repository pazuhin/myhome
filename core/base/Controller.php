<?php


namespace core\base;


abstract class Controller
{
    public $route;
    public $controller;
    public $model;
    public $view;
    public $layout;
    public $prefix;
    public $data = [];

    public function __construct($route)
    {
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->model = $route['controller'];
        $this->view = $route['action'];
        $this->prefix = $route['prefix'];
    }

    /**
     * @throws \Exception
     */
    public function getView()
    {
        $viewObj = new View($this->route, $this->layout, $this->view);
        $viewObj->render($this->data);
    }

    public function set($data)
    {
        $this->data = $data;
    }

    /**
     * @return bool
     */
    public function isAjax(): bool
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && (strtolower(getenv('HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest'));
    }

    /**
     * @param $view
     * @param array $vars
     */
    public function loadView($view, $vars = [])
    {
        extract($vars);
        require_once APP . "/views/{$this->prefix}{$this->controller}/{$view}.php";
        die;
    }
}