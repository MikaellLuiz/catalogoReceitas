<?php

namespace controller;

use generic\Controller;
use service\UsuarioService;

class UsuarioController extends Controller {
    private $service;

    public function __construct() {
        parent::__construct();
        $this->service = new UsuarioService();
    }

    public function criar() {
        try {
            $json = $this->getJsonInput();
            
            if (!isset($json['nome']) || !isset($json['email']) || !isset($json['senha'])) {
                throw new \Exception("Dados incompletos");
            }

            $usuario = $this->service->criar(
                $json['nome'],
                $json['email'],
                $json['senha']
            );

            $this->jsonResponse([
                'error' => false,
                'message' => 'Usuário criado com sucesso',
                'usuario' => $usuario
            ]);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'error' => true,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function listar() {
        try {
            $usuarios = $this->service->listar();
            $this->jsonResponse([
                'error' => false,
                'usuarios' => $usuarios
            ]);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'error' => true,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function buscar() {
        try {
            $id = $this->getParametro('id');
            
            if (!$id) {
                throw new \Exception("ID não fornecido");
            }

            if (!is_numeric($id)) {
                throw new \Exception("ID inválido");
            }

            $usuario = $this->service->buscarPorId($id);
            
            $this->jsonResponse([
                'error' => false,
                'usuario' => $usuario
            ]);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'error' => true,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function atualizar() {
        try {
            $id = $this->getParametro('id');
            
            if (!$id) {
                throw new \Exception("ID não fornecido");
            }

            if (!is_numeric($id)) {
                throw new \Exception("ID inválido");
            }

            $json = $this->getJsonInput();
            
            if (!isset($json['nome']) || !isset($json['email'])) {
                throw new \Exception("Nome e email são obrigatórios");
            }

            $usuario = $this->service->atualizar(
                $id,
                $json['nome'],
                $json['email'],
                $json['senha'] ?? null
            );

            $this->jsonResponse([
                'error' => false,
                'message' => 'Usuário atualizado com sucesso',
                'usuario' => $usuario
            ]);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'error' => true,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function excluir() {
        try {
            $id = $this->getParametro('id');
            
            if (!$id) {
                throw new \Exception("ID não fornecido");
            }

            if (!is_numeric($id)) {
                throw new \Exception("ID inválido");
            }

            $this->service->excluir($id);
            
            $this->jsonResponse([
                'error' => false,
                'message' => 'Usuário excluído com sucesso'
            ]);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'error' => true,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    private function verificarAutenticacao() {
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            return false;
        }

        $token = str_replace('Bearer ', '', $headers['Authorization']);
        return \generic\JWTManager::validateToken($token);
    }
} 