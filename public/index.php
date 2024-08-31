<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

// Crea la aplicación y funcionalidad
$app = AppFactory::create();

// Cargar las rutas
(require __DIR__ . '/../src/routes.php')($app);

// Ejecutar la aplicación
$app->run();

