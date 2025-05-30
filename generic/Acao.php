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
            $reflectMetodo = new ReflectionMethod($end->classe, $end->execucao);
            $parametros = $reflectMetodo->getParameters();
            
            // Para métodos POST, PUT, DELETE, deixa o controller processar os dados
            $metodo = $_SERVER["REQUEST_METHOD"];
            if (in_array($metodo, ['POST', 'PUT', 'DELETE']) || empty($parametros)) {
                return $reflectMetodo->invoke(new $end->classe());
            }
            
            // Para métodos GET com parâmetros, usa o processamento automático
            $returnParam = $this->getParam();
            $para = [];
            
            foreach($parametros as $v) {
                $name = $v->getName();
                
                if (!isset($returnParam[$name]) && !$v->isOptional()) {
                    return [
                        'erro' => "Parâmetro obrigatório '$name' não fornecido",
                        'parametros_esperados' => array_map(function($p) { return $p->getName(); }, $parametros)
                    ];
                }
                
                $para[$name] = $returnParam[$name] ?? ($v->isOptional() ? $v->getDefaultValue() : null);
            }

            return $reflectMetodo->invokeArgs(new $end->classe(), $para);
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
