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

    return $view;
};

// Load our routes file
require __DIR__ . '/../routes/web.php';
