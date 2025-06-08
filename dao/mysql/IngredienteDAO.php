<?php
namespace dao\mysql;

use dao\IIngredienteDAO;
use generic\MysqlFactory;

use Exception;

class IngredienteDAO extends MysqlFactory implements IIngredienteDAO {
    
    public function listar() {
        try {
            $sql = "SELECT id, nome FROM ingredientes ORDER BY nome";
            $retorno = $this->banco->executar($sql);
            return $retorno;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar ingredientes: " . $e->getMessage());
        }
    }

    public function listarId($id) {
        try {
            $sql = "SELECT id, nome FROM ingredientes WHERE id = :id";
            $param = [":id" => $id];
            $retorno = $this->banco->executar($sql, $param);
            return $retorno;
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar ingrediente por ID: " . $e->getMessage());
        }
    }

    public function inserir($nome) {
        try {
            $sql = "INSERT INTO ingredientes (nome) VALUES (:nome)";
            $param = [":nome" => $nome];
            $this->banco->executar($sql, $param);
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao inserir ingrediente: " . $e->getMessage());
        }
    }

    public function alterar($id, $nome) {
        try {
            $sql = "UPDATE ingredientes SET nome = :nome WHERE id = :id";
            $param = [
                ":id" => $id,
                ":nome" => $nome
            ];
            $this->banco->executar($sql, $param);
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao alterar ingrediente: " . $e->getMessage());
        }
    }

    public function excluir($id) {
        try {
            $sql = "DELETE FROM ingredientes WHERE id = :id";
            $param = [":id" => $id];
            $this->banco->executar($sql, $param);
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir ingrediente: " . $e->getMessage());
        }
    }
}
