<?php
namespace service;

use dao\mysql\ReceitaDAO;

class ReceitaService extends ReceitaDAO {
    
    private $dificuldadesValidas = ['Fácil', 'Média', 'Difícil'];

    public function listarReceitas() {
        return parent::listar();
    }    public function inserir($titulo, $descricao, $dificuldade, $tempo_preparo) {
        if (!$this->validarDificuldade($dificuldade)) {
            return "Erro: Dificuldade deve ser 'Fácil', 'Média' ou 'Difícil'. Recebido: '" . $dificuldade . "'";
        }
        
        if (!$this->validarTempoPreparo($tempo_preparo)) {
            return "Erro: Tempo de preparo deve ser um número positivo";
        }

        if (parent::inserir($titulo, $descricao, $dificuldade, $tempo_preparo)) {
            return "Receita salva com sucesso!";
        }
        return "Erro ao salvar receita";
    }

    public function alterar($id, $titulo, $descricao, $dificuldade, $tempo_preparo) {
        if (!$this->validarDificuldade($dificuldade)) {
            return "Erro: Dificuldade deve ser 'Fácil', 'Média' ou 'Difícil'";
        }
        
        if (!$this->validarTempoPreparo($tempo_preparo)) {
            return "Erro: Tempo de preparo deve ser um número positivo";
        }

        if (parent::alterar($id, $titulo, $descricao, $dificuldade, $tempo_preparo)) {
            return "Receita alterada com sucesso!";
        }
        return "Erro ao alterar receita";
    }

    public function excluir($id) {
        if (parent::excluir($id)) {
            return "Receita excluída com sucesso!";
        }
        return "Erro ao excluir receita";
    }

    public function listarId($id) {
        return parent::listarId($id);
    }

    public function adicionarIngrediente($receita_id, $ingrediente_id) {
        if (parent::inserirReceitaIngrediente($receita_id, $ingrediente_id)) {
            return "Ingrediente adicionado à receita com sucesso!";
        }
        return "Erro ao adicionar ingrediente à receita";
    }

    public function removerIngrediente($receita_id, $ingrediente_id) {
        if (parent::removerReceitaIngrediente($receita_id, $ingrediente_id)) {
            return "Ingrediente removido da receita com sucesso!";
        }
        return "Erro ao remover ingrediente da receita";
    }

    public function listarIngredientesPorReceita($receita_id) {
        return parent::listarIngredientesPorReceita($receita_id);
    }

    private function validarDificuldade($dificuldade) {
        return in_array($dificuldade, $this->dificuldadesValidas);
    }

    private function validarTempoPreparo($tempo_preparo) {
        return is_numeric($tempo_preparo) && $tempo_preparo > 0;
    }
}
