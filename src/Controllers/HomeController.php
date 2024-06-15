<?php

namespace App\Controllers;

use App\Core\Database;
use App\Models\User;

class HomeController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }


    public function index() {
        $connection = $this->db->getConnection();
        
        // Ejemplo de consulta a la base de datos
        $result = $connection->query("SELECT * FROM users");

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = new User($row['first_name'], $row['Last_name']);
        }
        require __DIR__ . '/../Views/home.php';
    }
}
