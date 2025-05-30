<?php
namespace dao\mysql;

use dao\IIngredienteDAO;
use generic\MysqlFactory;

class IngredienteDAO extends MysqlFactory implements IIngredienteDAO {
    
    public function listar() {
        $sql = "SELECT id, nome FROM ingredientes ORDER BY nome";
        $retorno = $this->banco->executar($sql);
        return $retorno;
    }

    public function listarId($id) {
        $sql = "SELECT id, nome FROM ingredientes WHERE id = :id";
        $param = [":id" => $id];
        $retorno = $this->banco->executar($sql, $param);
        return $retorno;
    }

    public function inserir($nome) {
        $sql = "INSERT INTO ingredientes (nome) VALUES (:nome)";
        $param = [":nome" => $nome];
        $this->banco->executar($sql, $param);
        return true;
    }

    public function alterar($id, $nome) {
        $sql = "UPDATE ingredientes SET nome = :nome WHERE id = :id";
        $param = [
            ":id" => $id,
            ":nome" => $nome
        ];
        $this->banco->executar($sql, $param);
        return true;
    }

    public function excluir($id) {
        $sql = "DELETE FROM ingredientes WHERE id = :id";
        $param = [":id" => $id];
        $this->banco->executar($sql, $param);
        return true;
    }
}
