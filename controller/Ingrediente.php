<?php
namespace controller;

use service\IngredienteService;

class Ingrediente {    public function listar() {
        $service = new IngredienteService();
        
        // Se há ID na URL, buscar ingrediente específico
        if (isset($_GET['id'])) {
            $resultado = $service->listarId($_GET['id']);
        } else {
            $resultado = $service->listarIngredientes();
        }
        
        return $resultado;
    }

    public function inserir() {
        $service = new IngredienteService();
        
        // Obter dados do corpo da requisição
        $dados = $this->obterDadosRequisicao();
        $nome = $dados['nome'] ?? '';
        
        if (empty($nome)) {
            return ['erro' => 'Nome do ingrediente é obrigatório'];
        }
        
        $resultado = $service->inserir($nome);
        return $resultado;
    }

    public function alterar() {
        $service = new IngredienteService();
        
        // Obter ID da URL
        $id = $_GET['id'] ?? null;
        if (!$id) {
            return ['erro' => 'ID do ingrediente é obrigatório para alteração'];
        }
        
        // Obter dados do corpo da requisição
        $dados = $this->obterDadosRequisicao();
        $nome = $dados['nome'] ?? '';
        
        if (empty($nome)) {
            return ['erro' => 'Nome do ingrediente é obrigatório'];
        }
        
        $resultado = $service->alterar($id, $nome);
        return $resultado;
    }

    public function excluir() {
        $service = new IngredienteService();
        
        // Obter ID da URL
        $id = $_GET['id'] ?? null;
        if (!$id) {
            return ['erro' => 'ID do ingrediente é obrigatório para exclusão'];
        }
        
        $resultado = $service->excluir($id);
        return $resultado;
    }
      private function obterDadosRequisicao() {
        $input = file_get_contents('php://input');
        
        // Tentar corrigir problemas de codificação UTF-8
        if (!mb_check_encoding($input, 'UTF-8')) {
            // Se não é UTF-8 válido, tentar converter de ISO-8859-1 para UTF-8
            $input = mb_convert_encoding($input, 'UTF-8', 'ISO-8859-1');
        }
        
        $dados = json_decode($input, true);
        
        // Se ainda falhou, tentar outras estratégias
        if ($dados === null && json_last_error() !== JSON_ERROR_NONE) {
            // Tentar limpar caracteres não UTF-8
            $input = mb_convert_encoding($input, 'UTF-8', 'UTF-8');
            $dados = json_decode($input, true);
        }
        
        // Se não conseguiu decodificar JSON, tentar form data
        if ($dados === null) {
            $dados = $_POST;
        }
        
        return $dados ?: [];
    }
}
