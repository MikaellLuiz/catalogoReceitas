<?php

namespace controller;

use generic\Controller;
use generic\JWTManager;
use service\UsuarioService;

class AuthController extends Controller {
    private $usuarioService;

    public function __construct() {
        $this->usuarioService = new UsuarioService();
    }

    public function login() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['email']) || !isset($data['senha'])) {
                throw new \Exception("Email e senha são obrigatórios");
            }

            $usuario = $this->usuarioService->autenticar($data['email'], $data['senha']);
            
            if (!$usuario) {
                throw new \Exception("Credenciais inválidas");
            }

            $token = JWTManager::generateToken($usuario['id'], $usuario['email']);

            header('Content-Type: application/json');
            echo json_encode([
                'error' => false,
                'message' => 'Login realizado com sucesso',
                'token' => $token,
                'usuario' => [
                    'id' => $usuario['id'],
                    'email' => $usuario['email'],
                    'nome' => $usuario['nome']
                ]
            ]);
            exit;
        } catch (\Exception $e) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode([
                'error' => true,
                'message' => $e->getMessage()
            ]);
            exit;
        }
    }
} 