<?php

require_once __DIR__ . '/../../config.php';

class Database {
    private $host = Config::DB_HOST; //"localhost";
    private $username = Config::DB_USERNAME; //"root";
    private $password = Config::DB_PASSWORD; //"";
    private $dbname = Config::DB_NAME; //"test";

    private static $instance = null;
    
    private $conn;

    private function __construct() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    private function __clone() {}

    public function __wakeup() {}
}
?>
