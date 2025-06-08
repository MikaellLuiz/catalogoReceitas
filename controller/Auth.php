<?php

namespace controller;

use service\AuthService;

use Exception;

class Auth
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    /**
     * Endpoint de login
     */
    public function login()
    {
        try {
            $dados = $this->obterDadosRequisicao();
            
            $email = $dados['email'] ?? '';
            $senha = $dados['senha'] ?? '';
            
            $resultado = $this->authService->login($email, $senha);
            
            if (!$resultado['sucesso']) {
                http_response_code($resultado['codigo'] ?? 400);
            }
            
            return $resultado;
            
        } catch (Exception $e) {
            http_response_code(500);
            return [
                'sucesso' => false,
                'erro' => 'Erro interno do servidor',
                'codigo' => 500
            ];
        }
    }

    /**
     * Endpoint de registro
     */
    public function registrar()
    {
        try {
            $dados = $this->obterDadosRequisicao();
            
            $email = $dados['email'] ?? '';
            $senha = $dados['senha'] ?? '';
            $nome = $dados['nome'] ?? '';
            
            $resultado = $this->authService->registrar($email, $senha, $nome);
            
            if (!$resultado['sucesso']) {
                http_response_code($resultado['codigo'] ?? 400);
            }
            
            return $resultado;
            
        } catch (Exception $e) {
            http_response_code(500);
            return [
                'sucesso' => false,
                'erro' => 'Erro interno do servidor',
                'codigo' => 500
            ];
        }
    }

    /**
     * Endpoint para validar token
     */
    public function validarToken()
    {
        try {
            $dados = $this->obterDadosRequisicao();
            $token = $dados['token'] ?? '';
            
            if (empty($token)) {
                // Tentar obter do header Authorization
                $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
                if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                    $token = $matches[1];
                }
            }
            
            if (empty($token)) {
                http_response_code(400);
                return [
                    'sucesso' => false,
                    'erro' => 'Token não fornecido',
                    'codigo' => 400
                ];
            }
            
            $resultado = $this->authService->validarToken($token);
            
            if (!$resultado['sucesso']) {
                http_response_code($resultado['codigo'] ?? 401);
            }
            
            return $resultado;
            
        } catch (Exception $e) {
            http_response_code(500);
            return [
                'sucesso' => false,
                'erro' => 'Erro interno do servidor',
                'codigo' => 500
            ];
        }
    }

    /**
     * Obtém dados da requisição
     */
    private function obterDadosRequisicao()
    {
        $json = file_get_contents('php://input');
        
        if ($json) {
            $dados = json_decode($json, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $dados;
            }
        }
        
        return $_POST;
    }
}
