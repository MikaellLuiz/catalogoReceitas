<?php

namespace generic;

class Rotas
{
    private $endpoints = [];    public function __construct()
    {
        // Rotas da API REST - URLs amigáveis
        $this->endpoints = [
            // Endpoints de Receita - CRUD completo
            "receita" => new Acao([
                Acao::GET => new Endpoint("Receita", "listar"),
                Acao::POST => new Endpoint("Receita", "inserir"),
                Acao::PUT => new Endpoint("Receita", "alterar"),
                Acao::DELETE => new Endpoint("Receita", "excluir")
            ]),
            
            // Endpoints específicos de Receita com ingredientes
            "receita/ingredientes" => new Acao([
                Acao::GET => new Endpoint("Receita", "listarIngredientes"),
                Acao::POST => new Endpoint("Receita", "adicionarIngrediente"),
                Acao::DELETE => new Endpoint("Receita", "removerIngrediente")
            ]),
            
            // Endpoints de Ingrediente - CRUD completo
            "ingrediente" => new Acao([
                Acao::GET => new Endpoint("Ingrediente", "listar"),
                Acao::POST => new Endpoint("Ingrediente", "inserir"),
                Acao::PUT => new Endpoint("Ingrediente", "alterar"),
                Acao::DELETE => new Endpoint("Ingrediente", "excluir")
            ])
        ];
    }

    public function executar($rota)
    {
        // verifica o array associativo se a rota existe
        if (isset($this->endpoints[$rota])) {
          
            $endpoint = $this->endpoints[$rota];
            $dados =$endpoint->executar();
            $retorno = new Retorno();
            $retorno ->dados = $dados;
            return $retorno;
        }

        return null;
    }
}
