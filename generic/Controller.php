<?php

namespace generic;

class Controller
{
    private $rotas = null;
    public function __construct()
    {
        $this->rotas = new Rotas();
    }    public function verificarChamadas($rota)
    {
        // Processar parâmetros da URL
        $this->processarParametrosUrl($rota);
        
        // Normalizar rota para compatibilidade
        $rotaNormalizada = $this->normalizarRota($rota);
        
        $retorno = $this->rotas->executar($rotaNormalizada);
          // Se existe um retorno irá devolver em formato json
        if ($retorno) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode($retorno, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            echo $json;
        } else {
            // Retornar erro 404 se rota não encontrada
            http_response_code(404);
            $erro = [
                'erro' => 'Endpoint não encontrado',
                'rota' => $rota,
                'metodo' => $_SERVER['REQUEST_METHOD']
            ];
            echo json_encode($erro, JSON_UNESCAPED_UNICODE);
        }
    }
    
    private function processarParametrosUrl($rota)
    {
        // Extrair ID da URL para operações específicas
        // Exemplo: receita/123 -> define $_GET['id'] = 123
        $partes = explode('/', $rota);
        
        if (count($partes) >= 2) {
            $recurso = $partes[0];
            $parametro = $partes[1];
            
            // Se o segundo parâmetro é numérico, é um ID
            if (is_numeric($parametro)) {
                $_GET['id'] = $parametro;
                
                // Para rotas com sub-recursos: receita/123/ingredientes
                if (count($partes) >= 3) {
                    $subrecurso = $partes[2];
                    
                    // Se existe um quarto parâmetro e é numérico
                    if (count($partes) >= 4 && is_numeric($partes[3])) {
                        $_GET['ingrediente_id'] = $partes[3];
                    }
                }
            }
            // Para rotas como receita/ingredientes
            elseif ($parametro === 'ingredientes') {
                // Se existe um ID antes de ingredientes: receita/123/ingredientes
                if (count($partes) >= 3) {
                    $_GET['receita_id'] = $partes[0] === 'receita' ? $partes[1] : null;
                }
            }
        }
    }
    
    private function normalizarRota($rota)
    {
        $partes = explode('/', $rota);
        
        // Remover IDs numéricos da rota para matching
        $rotaLimpa = [];
        foreach ($partes as $parte) {
            if (!is_numeric($parte)) {
                $rotaLimpa[] = $parte;
            }
        }
        
        return implode('/', $rotaLimpa);
    }
}
