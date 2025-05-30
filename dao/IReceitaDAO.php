<?php
namespace dao;

interface IReceitaDAO {
    public function listar();
    public function listarId($id);
    public function inserir($titulo, $descricao, $dificuldade, $tempo_preparo);
    public function alterar($id, $titulo, $descricao, $dificuldade, $tempo_preparo);
    public function excluir($id);
    public function inserirReceitaIngrediente($receita_id, $ingrediente_id);
    public function removerReceitaIngrediente($receita_id, $ingrediente_id);
    public function listarIngredientesPorReceita($receita_id);
}
