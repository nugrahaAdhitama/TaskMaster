<?php

/**
 * Represents a database connection.
 */
class Database {

    /**
     * The database connection object.
     *
     * @var PDO
     */
    public PDO $conn;

    /**
     * Database constructor.
     * 
     * @throws PDOException If connection fails.
     */
    public function __construct() {
        $host       = $_ENV["DB_HOST"];
        $name       = $_ENV["DB_NAME"];
        $username   = $_ENV["DB_USER"];
        $password   = $_ENV["DB_PASS"];

        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$name", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            exit("Connection failed: {$e->getMessage()}");
        }
    }

}
