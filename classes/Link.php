<?php


namespace App;


class Link
{
    private static $instance = null;
    private $container;

    private function __construct($container)
    {
        $this->container = $container;
    }

    public static function getInstance($container)
    {
        if (self::$instance == null) {
            self::$instance = new Link($container);
        }

        return self::$instance;
    }

    public function getHomeLink()
    {
        $this->container->get('router')->pathFor(_HOME_ROUTE_);
    }

    public static function getImageLink($image_filename)
    {
        return '/' . _BASE_DIR_ . _IMG_DIR_ . $image_filename;
    }
}


