<?php

/**
 * Provide your dependencies here so they are available everywhere
 */
return function ($container) {
    $container['link'] = \App\Link::getInstance($container);

    $container['view'] = function ($container) {
        $view = new \Slim\Views\Twig('theme', [
            'cache' => false
        ]);

        // Instantiate and add Slim specific extension
        $router = $container->get('router');
        $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
        $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

        foreach (\App\ThemeTools::getFunctions() as $f) {
            $view->getEnvironment()->addFunction($f);
        }

        return $view;
    };

    $container['db'] = \App\Db::getInstance($container['db_settings']);
};