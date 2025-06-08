<?php

namespace dao;

interface IUsuarioDAO 
{
    public function buscarPorEmail($email);
    public function inserir($email, $senha, $nome);
    public function alterar($id, $email, $senha, $nome, $ativo);
    public function excluir($id);
    public function listar();
    public function listarId($id);
    public function verificarCredenciais($email, $senha);
}
