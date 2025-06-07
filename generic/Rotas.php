<?php

namespace generic;

class Rotas
{
    private $endpoints;

    public function __construct()
    {
        // Rotas da API REST - URLs amigáveis
        $this->endpoints = [
            // Endpoint de Autenticação
            "login" => new Acao([
                Acao::POST => new Endpoint("AuthController", "login")
            ]),

            // Endpoint de Usuários
            "usuario" => new Acao([
                Acao::GET => new Endpoint("UsuarioController", "listar"),
                Acao::POST => new Endpoint("UsuarioController", "criar")
            ]),
            "usuario/{id}" => new Acao([
                Acao::GET => new Endpoint("UsuarioController", "buscar"),
                Acao::PUT => new Endpoint("UsuarioController", "atualizar"),
                Acao::DELETE => new Endpoint("UsuarioController", "excluir")
            ]),

            // Endpoints de Receita - CRUD completo
            "receita" => new Acao([
                Acao::GET => new Endpoint("ReceitaController", "listar"),
                Acao::POST => new Endpoint("ReceitaController", "criar")
            ]),
            "receita/{id}" => new Acao([
                Acao::GET => new Endpoint("ReceitaController", "buscar"),
                Acao::PUT => new Endpoint("ReceitaController", "atualizar"),
                Acao::DELETE => new Endpoint("ReceitaController", "excluir")
            ]),
            
            // Endpoints específicos de Receita com ingredientes
            "receita/ingredientes" => new Acao([
                Acao::GET => new Endpoint("Receita", "listarIngredientes"),
                Acao::POST => new Endpoint("Receita", "adicionarIngrediente"),
                Acao::DELETE => new Endpoint("Receita", "removerIngrediente")
            ]),
            
            // Endpoints de Ingrediente - CRUD completo
            "ingrediente" => new Acao([
                Acao::GET => new Endpoint("IngredienteController", "listar"),
                Acao::POST => new Endpoint("IngredienteController", "criar")
            ]),
            "ingrediente/{id}" => new Acao([
                Acao::GET => new Endpoint("IngredienteController", "buscar"),
                Acao::PUT => new Endpoint("IngredienteController", "atualizar"),
                Acao::DELETE => new Endpoint("IngredienteController", "excluir")
            ])
        ];
    }

    public function executar($rota)
    {
        // Remove a barra inicial se existir
        $rota = ltrim($rota, '/');
        
        // Se a rota exata existe, executa
        if (isset($this->endpoints[$rota])) {
            return $this->endpoints[$rota]->executar();
        }

        // Procura por rotas com parâmetros
        foreach ($this->endpoints as $padrao => $acao) {
            // Converte o padrão em uma expressão regular
            $regex = str_replace('{id}', '(\d+)', $padrao);
            $regex = str_replace('/', '\/', $regex);
            $regex = '/^' . $regex . '$/';

            // Se a rota atual corresponde ao padrão
            if (preg_match($regex, $rota)) {
                return $acao->executar();
            }
        }

        throw new \Exception("Endpoint não encontrado", 404);
    }
}


