<?php
namespace controller;

use service\ReceitaService;

use Exception;

class Receita {
    
    public function __construct() {
    }  
        public function listar() {
        try {
            $service = new ReceitaService();
            
            // Se há ID na URL, buscar receita específica
            if (isset($_GET['id'])) {
                $resultado = $service->listarId($_GET['id']);
            } else {
                $resultado = $service->listarReceitas();
            }
            
            return $resultado;
        } catch (Exception $e) {
            http_response_code(500);
            return [
                'erro' => 'Erro interno do servidor',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
        }
    }    public function inserir() {
        try {
            $service = new ReceitaService();
            
            // Obter dados do corpo da requisição
            $dados = $this->obterDadosRequisicao();
            
            $titulo = $dados['titulo'] ?? '';
            $descricao = $dados['descricao'] ?? '';
            $dificuldade = $dados['dificuldade'] ?? '';
            $tempo_preparo = $dados['tempo_preparo'] ?? 0;
            
            $resultado = $service->inserir($titulo, $descricao, $dificuldade, $tempo_preparo);
            return $resultado;
        } catch (Exception $e) {
            http_response_code(500);
            return [
                'erro' => 'Erro interno do servidor',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
        }
    }

    public function alterar() {
        $service = new ReceitaService();
        
        // Obter ID da URL
        $id = $_GET['id'] ?? null;
        if (!$id) {
            return ['erro' => 'ID da receita é obrigatório para alteração'];
        }
        
        // Obter dados do corpo da requisição
        $dados = $this->obterDadosRequisicao();
        
        $titulo = $dados['titulo'] ?? '';
        $descricao = $dados['descricao'] ?? '';
        $dificuldade = $dados['dificuldade'] ?? '';
        $tempo_preparo = $dados['tempo_preparo'] ?? 0;
        
        $resultado = $service->alterar($id, $titulo, $descricao, $dificuldade, $tempo_preparo);
        return $resultado;
    }

    public function excluir() {
        $service = new ReceitaService();
        
        // Obter ID da URL
        $id = $_GET['id'] ?? null;
        if (!$id) {
            return ['erro' => 'ID da receita é obrigatório para exclusão'];
        }
        
        $resultado = $service->excluir($id);
        return $resultado;
    }

    public function adicionarIngrediente() {
        $service = new ReceitaService();
        
        // Obter IDs da URL e corpo da requisição
        $receita_id = $_GET['id'] ?? $_GET['receita_id'] ?? null;
        $dados = $this->obterDadosRequisicao();
        $ingrediente_id = $dados['ingrediente_id'] ?? $_GET['ingrediente_id'] ?? null;
        
        if (!$receita_id || !$ingrediente_id) {
            return ['erro' => 'IDs da receita e ingrediente são obrigatórios'];
        }
        
        $resultado = $service->adicionarIngrediente($receita_id, $ingrediente_id);
        return $resultado;
    }

    public function removerIngrediente() {
        $service = new ReceitaService();
        
        // Obter IDs da URL
        $receita_id = $_GET['id'] ?? $_GET['receita_id'] ?? null;
        $ingrediente_id = $_GET['ingrediente_id'] ?? null;
        
        if (!$receita_id || !$ingrediente_id) {
            return ['erro' => 'IDs da receita e ingrediente são obrigatórios'];
        }
        
        $resultado = $service->removerIngrediente($receita_id, $ingrediente_id);
        return $resultado;
    }

    public function listarIngredientes() {
        $service = new ReceitaService();
        
        // Obter ID da receita da URL
        $receita_id = $_GET['id'] ?? $_GET['receita_id'] ?? null;
        if (!$receita_id) {
            return ['erro' => 'ID da receita é obrigatório'];
        }
        
        $resultado = $service->listarIngredientesPorReceita($receita_id);
        return $resultado;
    }    
    
    private function obterDadosRequisicao() {
        $input = file_get_contents('php://input');
        
        if (!mb_check_encoding($input, 'UTF-8')) {
            $input = mb_convert_encoding($input, 'UTF-8', 'ISO-8859-1');
        }
        
        $dados = json_decode($input, true);
        
        if ($dados === null && json_last_error() !== JSON_ERROR_NONE) {
            $input = mb_convert_encoding($input, 'UTF-8', 'UTF-8');
            $dados = json_decode($input, true);
        }
        
        if ($dados === null) {
            $dados = $_POST;
        }
        
        return $dados ?: [];
    }
}
