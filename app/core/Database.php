<?php

namespace App\Core;

/**
 * Represents a database connection.
 */
class Database {

    /**
     * The database connection object.
     *
     * @var \PDO
     */
    public \PDO $connection;

    /**
     * Database constructor.
     * 
     * @throws PDOException If connection fails.
     */
    public function __construct($host, $name, $username, $password) {
        try {
            $this->connection = new \PDO("mysql:host=$host;dbname=$name", $username, $password);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            exit("Connection failed: {$e->getMessage()}");
        }
    }

}
