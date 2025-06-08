<?php

namespace generic;

class Rotas
{
    private $endpoints = [];    public function __construct()
    {
        // Rotas da API REST - URLs amigáveis
        $this->endpoints = [
            // Endpoints de Autenticação - Públicos (sem autenticação)
            "auth/login" => new Acao([
                Acao::POST => new Endpoint("Auth", "login")
            ]),
            
            "auth/registrar" => new Acao([
                Acao::POST => new Endpoint("Auth", "registrar")
            ]),
            
            "auth/validar" => new Acao([
                Acao::POST => new Endpoint("Auth", "validarToken")
            ]),
            
            // Endpoints de Receita - CRUD completo (PROTEGIDOS)
            "receita" => new Acao([
                Acao::GET => new Endpoint("Receita", "listar", true),
                Acao::POST => new Endpoint("Receita", "inserir", true),
                Acao::PUT => new Endpoint("Receita", "alterar", true),
                Acao::DELETE => new Endpoint("Receita", "excluir", true)
            ]),
            
            // Endpoints específicos de Receita com ingredientes (PROTEGIDOS)
            "receita/ingredientes" => new Acao([
                Acao::GET => new Endpoint("Receita", "listarIngredientes", true),
                Acao::POST => new Endpoint("Receita", "adicionarIngrediente", true),
                Acao::DELETE => new Endpoint("Receita", "removerIngrediente", true)
            ]),
            
            // Endpoints de Ingrediente - CRUD completo (PROTEGIDOS)
            "ingrediente" => new Acao([
                Acao::GET => new Endpoint("Ingrediente", "listar", true),
                Acao::POST => new Endpoint("Ingrediente", "inserir", true),
                Acao::PUT => new Endpoint("Ingrediente", "alterar", true),
                Acao::DELETE => new Endpoint("Ingrediente", "excluir", true)
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


