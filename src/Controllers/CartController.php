<?php

namespace App\Controllers;

use App\Core\Database;

class CartController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function add()
    {
        $cart = json_decode(file_get_contents('php://input'), true);

        if (!is_array($cart)) {
            http_response_code(400);
            echo json_encode(['message' => 'Carrito inválido.']);
            return;
        }

        // Iniciar una transacción para asegurar la atomicidad de la operación
        $this->db->begin_transaction();

        try {
            // Verificar si ya existe una venta abierta para este usuario
            $userId = 1; // Esto debería venir del contexto del usuario autenticado
            $saleId = $this->getOpenSaleId($userId);

            if (!$saleId) {
                // Si no hay una venta abierta, crear una nueva
                $stmt = $this->db->prepare("INSERT INTO sales (date, user_id, total) VALUES (NOW(), ?, ?)");
                $total = $this->calculateTotal([$cart]); // Convertir $cart en array para el cálculo
                $stmt->bind_param("id", $userId, $total);
                $stmt->execute();
                $saleId = $stmt->insert_id;
            }

            // Manejar cada producto en el carrito
            if (isset($cart['id']) && isset($cart['quantity'])) {
                if ($this->isProductInSale($saleId, $cart['id'])) {
                    // Si el producto ya está en la venta, incrementar la cantidad
                    $quantity = $cart['quantity']; // Variable intermedia para la cantidad
                    $stmt = $this->db->prepare("UPDATE sales_details SET quantity = quantity + ? WHERE sale_id = ? AND product_id = ?");
                    $stmt->bind_param("iii", $quantity, $saleId, $cart['id']);
                } else {
                    // Si no, agregar una nueva línea en `sales_details`
                    $quantity = $cart['quantity']; // Variable intermedia para la cantidad
                    $price = $this->getProductPrice($cart['id']); // Variable intermedia para el precio
                    $stmt = $this->db->prepare("INSERT INTO sales_details (sale_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("iiid", $saleId, $cart['id'], $quantity, $price);
                }
                $stmt->execute();
            } else {
                throw new \Exception("Datos del producto incompletos.");
            }

            // Confirmar la transacción
            $this->db->commit();

            // Responder con un mensaje de éxito
            echo json_encode(['message' => 'Compra procesada exitosamente.', 'sale_id' => $saleId]);
        } catch (\Exception $e) {
            // En caso de error, revertir la transacción
            $this->db->rollback();
            http_response_code(500);
            echo json_encode(['message' => 'Error al procesar la compra.', 'error' => $e->getMessage()]);
        }
    }

    private function getOpenSaleId($userId)
    {
        // Implementar lógica para verificar si ya existe una venta en progreso para el usuario
        $stmt = $this->db->prepare("SELECT id FROM sales WHERE user_id = ? AND status = 'open'"); // Suponiendo que tienes un campo `status` para indicar si la venta está abierta o cerrada
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($saleId);
        if ($stmt->fetch()) {
            return $saleId;
        }
        return null;
    }

    private function isProductInSale($saleId, $productId)
    {
        // Verificar si un producto ya está en `sales_details`
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM sales_details WHERE sale_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $saleId, $productId);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        return $count > 0;
    }

    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            if (isset($item['id']) && isset($item['quantity'])) {
                $price = $this->getProductPrice($item['id']); // Variable intermedia para el precio
                $total += $price * $item['quantity'];
            }
        }
        return $total;
    }

    private function getProductPrice($productId)
    {
        // Consulta para obtener el precio del producto
        $stmt = $this->db->prepare("SELECT price FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $stmt->bind_result($price);
        $stmt->fetch();
        return $price;
    }

    public function list()
    {
        // Obtener todas las ventas abiertas
        $stmt = $this->db->prepare("SELECT sales.id, sales.date, sales.user_id, sales.total FROM sales WHERE status = 'open'");
        $stmt->execute();
        $sales = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $carts = [];
        foreach ($sales as $sale) {
            // Obtener los detalles de cada venta (carrito)
            $stmt = $this->db->prepare("SELECT sd.product_id, p.name, sd.quantity, sd.price FROM sales_details sd JOIN products p ON sd.product_id = p.id WHERE sd.sale_id = ?");
            $stmt->bind_param("i", $sale['id']);
            $stmt->execute();
            $details = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            $carts[] = [
                'sale_id' => $sale['id'],
                'date' => $sale['date'],
                'user_id' => $sale['user_id'],
                'total' => $sale['total'],
                'details' => $details
            ];
        }

        // Cargar la vista y pasarle los carritos
        require __DIR__ . '/../Views/cart/index.php';
    }
}
