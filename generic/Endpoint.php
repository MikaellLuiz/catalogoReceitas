<?php

namespace generic;

use generic\AuthMiddleware;

class Endpoint
{
    public $classe;
    public $execucao;
    public $requerAutenticacao;

    public function __construct($classe, $execucao, $requerAutenticacao = false)
    {
        $this->classe = "controller\\" . $classe;
        $this->execucao = $execucao;
        $this->requerAutenticacao = $requerAutenticacao;
    }

    public function executar()
    {
        // Verificar autenticação se necessário
        if ($this->requerAutenticacao) {
            $resultadoAuth = AuthMiddleware::verificarAutenticacao();
            if ($resultadoAuth !== true) {
                return $resultadoAuth; // Retorna erro de autenticação
            }
        }

        // Executar o método do controller
        $objeto = new $this->classe();
        return $objeto->{$this->execucao}();
    }
}
