<?php

namespace App\Controllers;

use App\Core\Database;

class AuthController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function showLoginForm() {
        require __DIR__ . '/../Views/login.php';
    }

    public function login() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $connection = $this->db->getConnection();
        $stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
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

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /login');
        exit();
    }
}
