<?php
namespace service;

use dao\mysql\IngredienteDAO;

use Exception;

class IngredienteService extends IngredienteDAO {
    
    public function listarIngredientes() {
        try {
            return parent::listar();
        } catch (Exception $e) {
            return [
                'erro' => 'Erro ao buscar ingredientes',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
        }
    }

    public function inserir($nome) {
        try {
            if (empty(trim($nome))) {
                return [
                    'erro' => 'Nome do ingrediente não pode estar vazio',
                    'codigo' => 400,
                    'timestamp' => date('Y-m-d H:i:s')
                ];
            }

            if (parent::inserir($nome)) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Ingrediente salvo com sucesso!',
                    'timestamp' => date('Y-m-d H:i:s')
                ];
            }
            
            return [
                'erro' => 'Erro ao salvar ingrediente',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
            
        } catch (Exception $e) {
            return [
                'erro' => 'Erro interno do servidor',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
        }
    }

    public function alterar($id, $nome) {
        try {
            if (empty(trim($nome))) {
                return [
                    'erro' => 'Nome do ingrediente não pode estar vazio',
                    'codigo' => 400,
                    'timestamp' => date('Y-m-d H:i:s')
                ];
            }

            if (parent::alterar($id, $nome)) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Ingrediente alterado com sucesso!',
                    'timestamp' => date('Y-m-d H:i:s')
                ];
            }
            
            return [
                'erro' => 'Erro ao alterar ingrediente',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
            
        } catch (Exception $e) {
            return [
                'erro' => 'Erro interno do servidor',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
        }
    }

    public function excluir($id) {
        try {
            if (parent::excluir($id)) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Ingrediente excluído com sucesso!',
                    'timestamp' => date('Y-m-d H:i:s')
                ];
            }
            
            return [
                'erro' => 'Erro ao excluir ingrediente',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
            
        } catch (Exception $e) {
            return [
                'erro' => 'Erro interno do servidor',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
        }
    }

    public function listarId($id) {
        try {
            return parent::listarId($id);
        } catch (Exception $e) {
            return [
                'erro' => 'Erro ao buscar ingrediente',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
        }
    }
}
