<?php


namespace App;


class IndexController extends Controller
{
    public function getContent()
    {
        parent::getContent();

        $this->render("index.twig");
    }
}