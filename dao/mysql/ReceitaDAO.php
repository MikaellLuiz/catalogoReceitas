<?php
namespace dao\mysql;

use dao\IReceitaDAO;
use generic\MysqlFactory;

class ReceitaDAO extends MysqlFactory implements IReceitaDAO {
    
    public function listar() {
        $sql = "SELECT id, titulo, descricao, dificuldade, tempo_preparo FROM receitas ORDER BY id";
        $retorno = $this->banco->executar($sql);
        return $retorno;
    }

    public function listarId($id) {
        $sql = "SELECT id, titulo, descricao, dificuldade, tempo_preparo FROM receitas WHERE id = :id";
        $param = [":id" => $id];
        $retorno = $this->banco->executar($sql, $param);
        return $retorno;
    }

    public function inserir($titulo, $descricao, $dificuldade, $tempo_preparo) {
        $sql = "INSERT INTO receitas (titulo, descricao, dificuldade, tempo_preparo) VALUES (:titulo, :descricao, :dificuldade, :tempo_preparo)";
        $param = [
            ":titulo" => $titulo,
            ":descricao" => $descricao,
            ":dificuldade" => $dificuldade,
            ":tempo_preparo" => $tempo_preparo
        ];
        $this->banco->executar($sql, $param);
        return true;
    }

    public function alterar($id, $titulo, $descricao, $dificuldade, $tempo_preparo) {
        $sql = "UPDATE receitas SET titulo = :titulo, descricao = :descricao, dificuldade = :dificuldade, tempo_preparo = :tempo_preparo WHERE id = :id";
        $param = [
            ":id" => $id,
            ":titulo" => $titulo,
            ":descricao" => $descricao,
            ":dificuldade" => $dificuldade,
            ":tempo_preparo" => $tempo_preparo
        ];
        $this->banco->executar($sql, $param);
        return true;
    }

    public function excluir($id) {
        $sql = "DELETE FROM receitas WHERE id = :id";
        $param = [":id" => $id];
        $this->banco->executar($sql, $param);
        return true;
    }

    public function inserirReceitaIngrediente($receita_id, $ingrediente_id) {
        $sql = "INSERT INTO receita_ingrediente (receita_id, ingrediente_id) VALUES (:receita_id, :ingrediente_id)";
        $param = [
            ":receita_id" => $receita_id,
            ":ingrediente_id" => $ingrediente_id
        ];
        $this->banco->executar($sql, $param);
        return true;
    }

    public function removerReceitaIngrediente($receita_id, $ingrediente_id) {
        $sql = "DELETE FROM receita_ingrediente WHERE receita_id = :receita_id AND ingrediente_id = :ingrediente_id";
        $param = [
            ":receita_id" => $receita_id,
            ":ingrediente_id" => $ingrediente_id
        ];
        $this->banco->executar($sql, $param);
        return true;
    }

    public function listarIngredientesPorReceita($receita_id) {
        $sql = "SELECT i.id, i.nome 
                FROM ingredientes i 
                INNER JOIN receita_ingrediente ri ON i.id = ri.ingrediente_id 
                WHERE ri.receita_id = :receita_id 
                ORDER BY i.nome";
        $param = [":receita_id" => $receita_id];
        $retorno = $this->banco->executar($sql, $param);
        return $retorno;
    }
}
