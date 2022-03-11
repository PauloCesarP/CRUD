<?php


namespace API\Controllers;

use CoffeeCode\Router\Router;
use League\Plates\Engine;


class controle
{
    protected $view;
    protected $router;

    public function __construct($router)
    {
        $this->router = $router;
        $this->view = Engine::create(dirname(__DIR__). "/views", "php");
        $this->view->addData(["router" => $this->router]);
    }
}