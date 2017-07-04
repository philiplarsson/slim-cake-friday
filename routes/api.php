<?php

use App\Controllers\CookieController;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->group('/api/v1', function () {
    $this->get('/thisweek', CookieController::class . ':getThisWeek')->setName('get-this-week');
    $this->get('/week/{week}', CookieController::class . ':getWeekCookie')->setName('get-week');
});


