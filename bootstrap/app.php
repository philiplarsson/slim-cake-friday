<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/../vendor/autoload.php';

$appConfiguration['settings'] = require __DIR__ . '/../config/app.php';
$app = new \Slim\App($appConfiguration);

$container = $app->getContainer();


// Load our routes file
require __DIR__ . '/../routes/web.php';
