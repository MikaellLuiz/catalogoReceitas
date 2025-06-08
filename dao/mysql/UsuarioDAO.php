<?php

namespace dao\mysql;

use dao\IUsuarioDAO;
use generic\MysqlFactory;
use Exception;

class UsuarioDAO extends MysqlFactory implements IUsuarioDAO
{
    public function buscarPorEmail($email)
    {
        try {
            $sql = "SELECT id, email, senha, nome, ativo FROM usuarios WHERE email = :email AND ativo = 1";
            $param = [":email" => $email];
            $resultado = $this->banco->executar($sql, $param);
            
            return !empty($resultado) ? $resultado[0] : false;
            
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar usuário por email: " . $e->getMessage());
        }
    }

    public function inserir($email, $senha, $nome)
    {
        try {
            // Hash da senha
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO usuarios (email, senha, nome, ativo) VALUES (:email, :senha, :nome, 1)";
            $param = [
                ":email" => $email,
                ":senha" => $senhaHash,
                ":nome" => $nome
            ];
            
            $this->banco->executar($sql, $param);
            return true;
            
        } catch (Exception $e) {
            throw new Exception("Erro ao inserir usuário: " . $e->getMessage());
        }
    }

    public function alterar($id, $email, $senha, $nome, $ativo)
    {
        try {
            if (!empty($senha)) {
                // Se senha foi fornecida, fazer hash
                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
                $sql = "UPDATE usuarios SET email = :email, senha = :senha, nome = :nome, ativo = :ativo WHERE id = :id";
                $param = [
                    ":email" => $email,
                    ":senha" => $senhaHash,
                    ":nome" => $nome,
                    ":ativo" => $ativo,
                    ":id" => $id
                ];
            } else {
                // Se senha não foi fornecida, não alterar
                $sql = "UPDATE usuarios SET email = :email, nome = :nome, ativo = :ativo WHERE id = :id";
                $param = [
                    ":email" => $email,
                    ":nome" => $nome,
                    ":ativo" => $ativo,
                    ":id" => $id
                ];
            }
            
            $this->banco->executar($sql, $param);
            return true;
            
        } catch (Exception $e) {
            throw new Exception("Erro ao alterar usuário: " . $e->getMessage());
        }
    }

    public function excluir($id)
    {
        try {
            $sql = "DELETE FROM usuarios WHERE id = :id";
            $param = [":id" => $id];
            $this->banco->executar($sql, $param);
            return true;
            
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir usuário: " . $e->getMessage());
        }
    }

    public function listar()
    {
        try {
            $sql = "SELECT id, email, nome, ativo, created_at FROM usuarios ORDER BY nome";
            $resultado = $this->banco->executar($sql);
            return $resultado;
            
        } catch (Exception $e) {
            throw new Exception("Erro ao listar usuários: " . $e->getMessage());
        }
    }

    public function listarId($id)
    {
        try {
            $sql = "SELECT id, email, nome, ativo, created_at FROM usuarios WHERE id = :id";
            $param = [":id" => $id];
            $resultado = $this->banco->executar($sql, $param);
            
            return !empty($resultado) ? $resultado[0] : false;
            
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar usuário por ID: " . $e->getMessage());
        }
    }

    public function verificarCredenciais($email, $senha)
    {
        try {
            $usuario = $this->buscarPorEmail($email);
            
            if ($usuario && password_verify($senha, $usuario['senha'])) {
                // Remove a senha do retorno por segurança
                unset($usuario['senha']);
                return $usuario;
            }
            
            return false;
            
        } catch (Exception $e) {
            throw new Exception("Erro ao verificar credenciais: " . $e->getMessage());
        }
    }
}
