<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Env;
use App\Controllers\HomeController;

Env::load(__DIR__ . '/../');

$controller = new HomeController();
$controller->index();
