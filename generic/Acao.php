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

    private $endpoint;

    public function __construct($endpoint = [])
    {
       
        $this->endpoint = $endpoint;
    }    public function executar()
    {
        $end = $this->endpointMetodo();
       
        if ($end) {
            // Usar o novo método executar do Endpoint que verifica autenticação
            return $end->executar();
        }
        
        return null;
    }

    private function endpointMetodo()
    {
        return isset($this->endpoint[$_SERVER["REQUEST_METHOD"]]) ? $this->endpoint[$_SERVER["REQUEST_METHOD"]] : null;
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
