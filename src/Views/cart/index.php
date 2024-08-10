<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carritos de Compras</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Carritos de Compras</h1>
        <?php if (!empty($carts)) : ?>
            <?php foreach ($carts as $cart) : ?>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5>Carrito ID: <?php echo $cart['sale_id']; ?></h5>
                        <p>Fecha: <?php echo $cart['date']; ?></p>
                        <p>ID Usuario: <?php echo $cart['user_id']; ?></p>
                        <p>Total: $<?php echo number_format($cart['total'], 2); ?></p>
                    </div>
                    <div class="card-body">
                        <h6>Detalles del Carrito</h6>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID Producto</th>
                                    <th>Nombre</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart['details'] as $detail) : ?>
                                    <tr>
                                        <td><?php echo $detail['product_id']; ?></td>
                                        <td><?php echo $detail['name']; ?></td>
                                        <td><?php echo $detail['quantity']; ?></td>
                                        <td>$<?php echo number_format($detail['price'], 2); ?></td>
                                        <td>$<?php echo number_format($detail['quantity'] * $detail['price'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No hay carritos abiertos en este momento.</p>
        <?php endif; ?>
    </div>
</body>

</html>