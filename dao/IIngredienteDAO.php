<?php
namespace dao;

interface IIngredienteDAO {
    public function listar();
    public function listarId($id);
    public function inserir($nome);
    public function alterar($id, $nome);
    public function excluir($id);
}
