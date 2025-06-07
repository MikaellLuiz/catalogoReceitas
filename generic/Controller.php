<?php

namespace generic;

class Controller
{
    private $rotas = null;
    public function __construct()
    {
        $this->rotas = new Rotas();
    }

    public function verificarChamadas($rota)
    {
        $rotas = new Rotas();
        return $rotas->executar($rota);
    }
    
    protected function processarParametrosUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        $partes = explode('/', trim($url, '/'));
        return array_slice($partes, 1);
    }
    
    protected function normalizarRota($rota)
    {
        return strtolower($rota);
    }

    protected function getParametro($nome) {
        $parametros = $this->processarParametrosUrl();
        
        // Se o nome for 'id', procura o último número na URL
        if ($nome === 'id') {
            foreach (array_reverse($parametros) as $param) {
                if (is_numeric($param)) {
                    return $param;
                }
            }
            return null;
        }
        
        // Para outros parâmetros, procura pelo padrão nome/valor
        $indice = array_search($nome, $parametros);
        if ($indice !== false && isset($parametros[$indice + 1])) {
            return $parametros[$indice + 1];
        }
        
        return null;
    }

    protected function getJsonInput() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("JSON inválido");
        }
        
        return $data;
    }

    protected function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
