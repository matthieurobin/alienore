<?php

namespace MVC;

class Connexion {

    private static $_pdo;

    private function __construct() {
        $dsn = 'mysql:dbname='. \Config\App::BDD_NAME. ';host='. \Config\App::BDD_HOST;     
        self::$_pdo = new \PDO($dsn, \Config\App::BDD_USER, \Config\App::BDD_PASSWORD, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        self::$_pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    static public function get() {
        if (!isset(self::$_pdo)) {
           new \MVC\Connexion();
        }
        return self::$_pdo;
    }

    static public function query($statement){     
        return self::get()->query($statement);
    }
    static function prepare($statement, $driver_options = array()) {
        return self::get()->prepare($statement, $driver_options);
    }
    
}