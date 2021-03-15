<?php


namespace core\base;

use core\Db;
use core\DBCriteria;

abstract class Model
{
    public $attributes = [];
    public $errors = [];
    public $pdo;

    public function __construct()
    {
        $this->pdo = DBCriteria::instance();
    }

    public function load(array $data)
    {
        foreach ($this->attributes as $name => $value) {
            if (isset($data[$name])) {
                $this->attributes[$name] = $data[$name];
            }
        }
    }

    public function getErrors(): void
    {
        $errors = '<ul>';
        foreach ($this->errors as $error) {
            foreach ($error as $item) {
                $errors .= '<li>' . $item . '</li>';
            }
        }
        $errors .= '</ul>';
        $_SESSION['errors'] = $errors;
    }
}