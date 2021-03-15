<?php


namespace core\base;


class View
{
    public $route;
    public $controller;
    public $model;
    public $view;
    public $prefix;
    public $layout;

    public function __construct($route, $layout = '', $view = '')
    {
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->model = $route['controller'];
        $this->view = $view;
        $this->prefix = $route['prefix'];

        if ($layout === false) {
            $this->layout = false;
        } else {
            $this->layout = $layout ?: LAYOUT;
        }
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    public function render(array $data)
    {
        extract($data);

        $viewFile = APP . "/views/{$this->prefix}{$this->controller}/{$this->view}.php";

        if (is_file($viewFile)){
            ob_start();
            require_once $viewFile;
            $content = ob_get_clean();
        } else {
            throw new \Exception('View not found', 500);
        }
        if ($this->layout !== false) {
            $layout = APP . "/views/layouts/{$this->layout}.php";
            if (is_file($layout)){
                require_once $layout;
            } else {
                throw new \Exception('Layout not found', 500);
            }
        }
    }
}