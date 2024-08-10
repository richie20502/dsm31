<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;

class ProductController
{
    private $product;
    private $category;

    public function __construct()
    {
        $this->product = new Product();
        $this->category = new Category();
    }

    public function index()
    {
        $products = $this->product->getAll();
        require __DIR__ . '/../Views/products/index.php';
    }

    public function create()
    {
        $categories = $this->category->getAll();
        require __DIR__ . '/../Views/products/create.php';
    }

    public function store()
    {
        $data = $_POST;
        $this->product->create($data);
        header('Location: /products');
    }

    public function edit($id)
    {
        $product = $this->product->getById($id);
        $categories = $this->category->getAll();
        require __DIR__ . '/../Views/products/edit.php';
    }

    public function update($id)
    {
        $data = $_POST;
        $this->product->update($id, $data);
        header('Location: /products');
    }

    public function delete($id)
    {
        $this->product->delete($id);
        header('Location: /products');
    }


    public function addToCart($productId)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $productId = $data['productId'] ?? null;
        header('Content-Type: application/json');
        session_start();
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $product = $this->product->getById($productId);
        if ($product && $product['stock'] > 0) {
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]['quantity']++;
            } else {
                $_SESSION['cart'][$productId] = ['quantity' => 1, 'price' => $product['price']];
            }
            return json_encode(['status' => 'success', 'message' => 'Product added to cart']);
        } else {
            return json_encode(['status' => 'error', 'message' => 'Product not available']);
        }
    }
}
