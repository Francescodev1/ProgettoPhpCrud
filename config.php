<?php

class Database {
    private static $instance = null;
    private $conn;
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $name = 'progettophpcrud';
    private $port = 3306;

    private function __construct() {
        $this->conn = new PDO("mysql:host={$this->host};dbname={$this->name};port={$this->port}", $this->user, $this->pass);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}
