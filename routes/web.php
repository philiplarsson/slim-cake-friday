<?php

use App\Controllers\CookieController;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', CookieController::class . ':index')->setName('home');
$app->get('/api', CookieController::class . ':apiInfo')->setName('api-info');
