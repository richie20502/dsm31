<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Env;
use App\Core\Router;

// Cargar variables de entorno
Env::load(__DIR__ . '/../');

// Instanciar el router
$router = new Router();

// Definir las rutas
require __DIR__ . '/../routes.php';

// Despachar la solicitud actual
$router->dispatch();
