<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Env;

Env::load(__DIR__ . '/../');

$router = require __DIR__ . '/../routes.php';


$router->dispatch();