<?php

namespace App\Models;

use App\Core\Database;

class Product {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $sql = "SELECT * FROM products";
        $result = $this->conn->query($sql);

        $products = [];
        while($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }

    public function getById($id) {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($data) {
        $sql = "INSERT INTO products (name, description, price, stock, category_id, supplier_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssdiis", $data['name'], $data['description'], $data['price'], $data['stock'], $data['category_id'], $data['supplier_id']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $sql = "UPDATE products SET name = ?, description = ?, price = ?, stock = ?, category_id = ?, supplier_id = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssdiisi", $data['name'], $data['description'], $data['price'], $data['stock'], $data['category_id'], $data['supplier_id'], $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
