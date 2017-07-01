<?php

use App\Controllers\CookieController;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->group('/api/v1/week', function () {
    $this->get('/{week}', CookieController::class . ':getWeekCookie');
});
