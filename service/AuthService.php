<?php

namespace service;

use dao\mysql\UsuarioDAO;
use generic\JwtHelper;
use Exception;

class AuthService
{
    private $usuarioDAO;

    public function __construct()
    {
        $this->usuarioDAO = new UsuarioDAO();
    }

    /**
     * Realiza login e retorna token JWT
     */
    public function login($email, $senha)
    {
        try {
            if (empty($email) || empty($senha)) {
                return [
                    'sucesso' => false,
                    'erro' => 'Email e senha são obrigatórios',
                    'codigo' => 400
                ];
            }

            $usuario = $this->usuarioDAO->verificarCredenciais($email, $senha);

            if (!$usuario) {
                return [
                    'sucesso' => false,
                    'erro' => 'Credenciais inválidas',
                    'codigo' => 401
                ];
            }

            // Gerar token JWT
            $payload = [
                'user_id' => $usuario['id'],
                'email' => $usuario['email'],
                'nome' => $usuario['nome']
            ];

            $token = JwtHelper::encode($payload);

            return [
                'sucesso' => true,
                'token' => $token,
                'usuario' => [
                    'id' => $usuario['id'],
                    'email' => $usuario['email'],
                    'nome' => $usuario['nome']
                ],
                'expires_in' => 3600 // 1 hora
            ];

        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'erro' => 'Erro interno do servidor',
                'codigo' => 500,
                'detalhes' => $e->getMessage()
            ];
        }
    }

    /**
     * Valida token JWT
     */
    public function validarToken($token)
    {
        try {
            $payload = JwtHelper::decode($token);
            return [
                'sucesso' => true,
                'usuario' => $payload
            ];

        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'erro' => 'Token inválido',
                'codigo' => 401
            ];
        }
    }

    /**
     * Registra novo usuário
     */
    public function registrar($email, $senha, $nome)
    {
        try {
            if (empty($email) || empty($senha) || empty($nome)) {
                return [
                    'sucesso' => false,
                    'erro' => 'Email, senha e nome são obrigatórios',
                    'codigo' => 400
                ];
            }

            // Verificar se email já existe
            $usuarioExistente = $this->usuarioDAO->buscarPorEmail($email);
            if ($usuarioExistente) {
                return [
                    'sucesso' => false,
                    'erro' => 'Email já está em uso',
                    'codigo' => 409
                ];
            }

            $resultado = $this->usuarioDAO->inserir($email, $senha, $nome);

            if ($resultado) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Usuário registrado com sucesso'
                ];
            } else {
                return [
                    'sucesso' => false,
                    'erro' => 'Erro ao registrar usuário',
                    'codigo' => 500
                ];
            }

        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'erro' => 'Erro interno do servidor',
                'codigo' => 500,
                'detalhes' => $e->getMessage()
            ];
        }
    }
}
