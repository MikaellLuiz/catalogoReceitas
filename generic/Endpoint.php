<?php

namespace generic;

class Endpoint
{
    private $controller;
    private $metodo;

    public function __construct($controller, $metodo)
    {
        $this->controller = $controller;
        $this->metodo = $metodo;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getMetodo()
    {
        return $this->metodo;
    }
}
