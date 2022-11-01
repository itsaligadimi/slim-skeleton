<?php

/**
 * Add your routes here
 */
return function ($app) {
    $app->any('/', App\IndexController::class)->setName(_HOME_ROUTE_);
};