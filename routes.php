<?php

use App\Core\Router;

$router = new Router();

// Definir las rutas
$router->add('/', 'HomeController@index');
$router->add('/login', 'AuthController@showLoginForm');
$router->add('/login', 'AuthController@login', 'POST');
$router->add('/logout', 'AuthController@logout');
$router->add('/register', 'AuthController@showRegisterForm');
$router->add('/register', 'AuthController@register', 'POST');

return $router;