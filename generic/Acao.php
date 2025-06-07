<?php

namespace generic;

use ReflectionMethod;

class Acao
{

    const POST = "POST";
    const GET = "GET";
    const PUT = "PUT";
    const PATCH = "PATCH";
    const DELETE = "DELETE";

    private $endpoints;

    public function __construct($endpoints)
    {
        $this->endpoints = $endpoints;
    }

    public function executar()
    {
        $metodo = $_SERVER['REQUEST_METHOD'];

        if (!isset($this->endpoints[$metodo])) {
            throw new \Exception("Método não permitido", 405);
        }

        $endpoint = $this->endpoints[$metodo];
        $controller = "controller\\" . $endpoint->getController();
        $metodo = $endpoint->getMetodo();

        $instancia = new $controller();
        return $instancia->$metodo();
    }

    private function endpointMetodo()
    {
        return isset($this->endpoints[$_SERVER["REQUEST_METHOD"]]) ? $this->endpoints[$_SERVER["REQUEST_METHOD"]] : null;
    }

    private function getPost(){
        if($_POST){
            return $_POST;
        }
        return [];
    }
     private function getGet(){
        if($_GET){
            $get = $_GET;
            unset($get["param"]);
            return $get;
        }
        return [];
    }    private function getInput(){
        $input = file_get_contents("php://input");
         
        if($input){
            $decoded = json_decode($input, true);
            return $decoded ?: [];
        }
        return [];
    }public function getParam(){
        // Para métodos POST, PUT, DELETE, não processar php://input aqui
        // pois os controllers vão precisar lê-lo
        $metodo = $_SERVER["REQUEST_METHOD"];
        if (in_array($metodo, ['POST', 'PUT', 'DELETE'])) {
            return array_merge($this->getPost(), $this->getGet());
        }
        
        return array_merge($this->getPost(), $this->getGet(), $this->getInput());
    }

}
