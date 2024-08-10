<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function addToCart(productId, maxStock) {
            // Obtener la cantidad seleccionada por el usuario
            let quantity = parseInt(document.getElementById('quantity_' + productId).value);

            // Verificar que la cantidad no exceda el stock disponible
            if (quantity > maxStock) {
                alert('La cantidad no puede exceder el stock disponible.');
                return;
            }

            // Recuperar el carrito de localStorage o inicializarlo si no existe
            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            // Verificar si el producto ya está en el carrito
            let existingProduct = cart.find(item => item.id === productId);

            if (existingProduct) {
                // Si el producto ya existe en el carrito, actualizar la cantidad
                existingProduct.quantity = quantity;
            } else {
                // Si no, añade el nuevo producto al carrito
                cart.push({
                    id: productId,
                    quantity: quantity
                });
            }

            // Guardar el carrito actualizado en localStorage
            localStorage.setItem('cart', JSON.stringify(cart));

            // Notificar al usuario que el producto se ha añadido al carrito
            alert("Producto añadido al carrito.");

            // Enviar solo el producto seleccionado al servidor
            $.ajax({
                url: '/cart/add',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    id: productId,
                    quantity: quantity
                }),
                success: function(response) {
                    console.log("Respuesta recibida:", response);
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud:", status, error);
                    alert("Error al añadir producto al carrito.");
                }
            });
        }

        function displayCart() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            console.log('Carrito actual:', cart);
        }

        // Mostrar el carrito en la consola al cargar la página
        $(document).ready(function() {
            displayCart();
        });
    </script>
</head>

<body>
    <div class="container">
        <h1>Products</h1>
        <a href="/products/create" class="btn btn-primary">Agregar Producto</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['description']; ?></td>
                        <td><?php echo $product['price']; ?></td>
                        <td><?php echo $product['stock']; ?></td>
                        <td>
                            <input type="number" id="quantity_<?php echo $product['id']; ?>" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>" class="form-control" style="width: 80px;">
                        </td>
                        <td>
                            <a href="/products/edit/<?php echo $product['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="/products/delete/<?php echo $product['id']; ?>" class="btn btn-danger">Delete</a>
                            <button onclick="addToCart(<?php echo $product['id']; ?>, <?php echo $product['stock']; ?>)" class="btn btn-success">Add to Cart</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>