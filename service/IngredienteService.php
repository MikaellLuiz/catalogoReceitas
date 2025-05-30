<?php
namespace service;

use dao\mysql\IngredienteDAO;

class IngredienteService extends IngredienteDAO {
    
    public function listarIngredientes() {
        return parent::listar();
    }

    public function inserir($nome) {
        if (empty(trim($nome))) {
            return "Erro: Nome do ingrediente não pode estar vazio";
        }

        if (parent::inserir($nome)) {
            return "Ingrediente salvo com sucesso!";
        }
        return "Erro ao salvar ingrediente";
    }

    public function alterar($id, $nome) {
        if (empty(trim($nome))) {
            return "Erro: Nome do ingrediente não pode estar vazio";
        }

        if (parent::alterar($id, $nome)) {
            return "Ingrediente alterado com sucesso!";
        }
        return "Erro ao alterar ingrediente";
    }

    public function excluir($id) {
        if (parent::excluir($id)) {
            return "Ingrediente excluído com sucesso!";
        }
        return "Erro ao excluir ingrediente";
    }

    public function listarId($id) {
        return parent::listarId($id);
    }
}
