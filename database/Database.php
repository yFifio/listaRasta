<?php

class Database {
    private static $instance = null;
    private $pdo;

    private $hostname = 'localhost';
    private $database = 'to_do';
    private $username = 'root';
    private $password = '';
    private $port = 3306;

    private function __construct() {
        try {
            $dsn = "mysql:host={$this->hostname};port={$this->port};dbname={$this->database};charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
                PDO::ATTR_EMULATE_PREPARES   => false, 
            ];
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
     
            throw $e;
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}