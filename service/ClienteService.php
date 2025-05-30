<?php
namespace service;

use dao\mysql\ClienteDAO;

class ClienteService extends ClienteDAO{
    public function listarCliente(){
        
        return parent::listar();
    }

    public function inserir($nome,$endereco){
        if(parent::inserir($nome,$endereco)){
            return "Dados Salvo com Sucesso!";
        }
        return null;
    }    public function alterar($id, $nome, $endereco)
    {
        if(parent::alterar($id,$nome,$endereco)){
            return "Cliente alterado com sucesso!";
        }
        return "Erro ao alterar cliente";
    }
    
    public function excluir($id)
    {
        if(parent::excluir($id)){
            return "Cliente excluído com sucesso!";
        }
        return "Erro ao excluir cliente";
    }
    
    public function listarId($id)
    {
        return parent::listarId($id);
    }
}