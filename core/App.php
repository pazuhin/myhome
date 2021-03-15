<?php


namespace core;

class App
{
    public static $app;

    public function __construct()
    {
        $query = trim($_SERVER['REQUEST_URI'], '/');
        $router = new Router();
        $router->dispatch($query);
    }
}