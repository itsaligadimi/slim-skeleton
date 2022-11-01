<?php
require_once 'config/defines.php';
require 'vendor/autoload.php';

$app = new \Slim\App(require_once("config/settings.php"));


$container = $app->getContainer();

// register dependencies
$deps = include_once("app/dependency.php");
$deps($container);

// register middlewares
$mids = include_once("app/middleware.php");
$mids($app);

// register routes
$rots = include_once("app/route.php");
$rots($app);


$app->run();