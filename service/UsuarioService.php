<?php

namespace service;

use dao\UsuarioDAO;

class UsuarioService {
    private $dao;

    public function __construct() {
        $this->dao = new UsuarioDAO();
    }

    public function autenticar($email, $senha) {
        try {
            $usuario = $this->dao->buscarPorEmail($email);
            
            if (!$usuario) {
                return false;
            }

            if (!password_verify($senha, $usuario['senha'])) {
                return false;
            }

            return $usuario;
        } catch (\Exception $e) {
            throw new \Exception("Erro ao autenticar usuário: " . $e->getMessage());
        }
    }

    public function criar($nome, $email, $senha) {
        // Validações
        if (empty($nome) || empty($email) || empty($senha)) {
            throw new \Exception("Todos os campos são obrigatórios");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("Email inválido");
        }

        if (strlen($senha) < 6) {
            throw new \Exception("A senha deve ter no mínimo 6 caracteres");
        }

        // Hash da senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        return $this->dao->criar($nome, $email, $senhaHash);
    }

    public function listar() {
        return $this->dao->listar();
    }

    public function buscarPorId($id) {
        if (!is_numeric($id)) {
            throw new \Exception("ID inválido");
        }
        return $this->dao->buscarPorId($id);
    }

    public function atualizar($id, $nome, $email, $senha = null) {
        // Validações
        if (!is_numeric($id)) {
            throw new \Exception("ID inválido");
        }

        if (empty($nome) || empty($email)) {
            throw new \Exception("Nome e email são obrigatórios");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("Email inválido");
        }

        // Se a senha for fornecida, valida e faz o hash
        $senhaHash = null;
        if ($senha) {
            if (strlen($senha) < 6) {
                throw new \Exception("A senha deve ter no mínimo 6 caracteres");
            }
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        }

        return $this->dao->atualizar($id, $nome, $email, $senhaHash);
    }

    public function excluir($id) {
        if (!is_numeric($id)) {
            throw new \Exception("ID inválido");
        }
        return $this->dao->excluir($id);
    }
} 