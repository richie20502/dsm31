<?php

namespace App\Controllers;

use App\Core\Database;

class AuthController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance(); // Solo instancia Database
    }

    public function showLoginForm() {
        require __DIR__ . '/../Views/login.php';
    }

    public function showRegisterForm() {
        require __DIR__ . '/../Views/register.php';
    }

    public function login() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $connection = $this->db->getConnection(); // Obtiene la conexión directamente
        $stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                header('Location: /');
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "Invalid username.";
        }
    }

    public function register() {
    
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $user_type_id = 1;
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
    
        if ($password !== $confirm_password) {
            echo "Passwords do not match.";
            return;
        }
    
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        $connection = $this->db->getConnection(); // Obtiene la conexión directamente
        $stmt = $connection->prepare("INSERT INTO users (first_name, last_name, email, phone, address, user_type_id, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssis", $first_name, $last_name, $email, $phone, $address, $user_type_id, $hashed_password);
    
        if ($stmt->execute()) {
            header('Location: /login');
            exit();
        } else {
            echo "Error: Could not register user.";
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /login');
        exit();
    }
}
