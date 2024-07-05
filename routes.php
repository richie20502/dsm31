<?php

use App\Core\Router;
use App\Middleware\AuthMiddleware;

$router = new Router();

// Definir las rutas
$router->add('/', 'HomeController@index');
$router->add('/login', 'AuthController@showLoginForm');
$router->add('/login', 'AuthController@login', 'POST');
$router->add('/logout', 'AuthController@logout');
$router->add('/register', 'AuthController@showRegisterForm');
$router->add('/register', 'AuthController@register', 'POST');

// Rutas protegidas por el middleware de autenticación
$router->add('/dashboard', 'DashboardController@index', 'GET', [[AuthMiddleware::class, 'handle']]);
$router->add('/profile', 'ProfileController@show', 'GET', [[AuthMiddleware::class, 'handle']]);

return $router;
