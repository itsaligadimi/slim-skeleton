<?php


namespace App;


class ThemeTools
{
    public static function getFunctions(){
        $functions = [];

        $functions[] = new \Twig\TwigFunction('printCode', function ($data) {
            Tools::printCode($data);
        });

        return $functions;
    }
}
