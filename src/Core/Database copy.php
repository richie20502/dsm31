<?php

namespace App\Core;

use mysqli;

class Database {
    private $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $host = $_ENV['DB_HOST'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];
        $database = $_ENV['DB_NAME'];

        $this->connection = new mysqli($host, $user, $password, $database);

        if ($this->connection->connect_error) {
            die('Connection failed: ' . $this->connection->connect_error);
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function __destruct() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}