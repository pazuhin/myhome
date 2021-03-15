<?php


namespace core;

class DBCriteria
{
    private $pdo;

    protected static $instance;

    protected function __construct() {}

    public static function instance()
    {
        if (self::$instance === null)
        {
            require_once('../config/database.php');
            try {
                self::$instance = new \PDO($dsn, $user, $password, [\PDO::ATTR_PERSISTENT => false]);
            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }
        return self::$instance;
    }
}