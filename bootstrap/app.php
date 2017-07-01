<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/../vendor/autoload.php';

$appConfiguration['settings'] = require __DIR__ . '/../config/app.php';
$app = new \Slim\App($appConfiguration);

$container = $app->getContainer();

// Add Twig
$container['view'] = function($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../templates', [
        'cache' => false,
        'debug' => true,
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    // Enable the dump function
    $view->addExtension(new Twig_Extension_Debug());
    return $view;
};

// Database
$container['db'] = function ($container) {
    $pdo = new PDO("sqlite:" . __DIR__ . '/../database/database.db');
    // Throw exception if there are any errors.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
};

// Load our routes file
require __DIR__ . '/../routes/web.php';
