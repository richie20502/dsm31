<?php

namespace App\Models;

use App\Core\Database;

class Category {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $sql = "SELECT * FROM product_categories";
        $result = $this->conn->query($sql);

        if (!$result) {
            die('Query failed: ' . $this->conn->error);
        }

        $categories = [];
        while($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
        return $categories;
    }
}
