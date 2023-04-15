<?php

class Database {

    public $conn;

    public function __construct() {
        $host       = $_ENV["DB_HOST"];
        $db_name    = $_ENV["DB_NAME"];
        $username   = $_ENV["DB_USER"];
        $password   = $_ENV["DB_PASS"];

        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        return $this;
    }

}
