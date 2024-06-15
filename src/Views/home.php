<!-- src/Views/home.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
    <h1>Lista de Usuarios</h1>
    <ul>
        <?php foreach ($users as $user): ?>
            <li><?php echo $user->getFullName(); ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>