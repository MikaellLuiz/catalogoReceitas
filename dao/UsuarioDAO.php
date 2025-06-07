<?php

namespace dao;

use generic\MysqlSingleton;

class UsuarioDAO {
    private $db;

    public function __construct() {
        $this->db = MysqlSingleton::getInstance();
    }

    public function buscarPorEmail($email) {
        try {
            $sql = "SELECT id, nome, email, senha FROM usuarios WHERE email = :email";
            $stmt = $this->db->executar($sql, [':email' => $email]);
            return $stmt[0] ?? false;
        } catch (\Exception $e) {
            throw new \Exception("Erro ao buscar usuário: " . $e->getMessage());
        }
    }

    public function criar($nome, $email, $senha) {
        // Verifica se o email já existe
        $query = "SELECT id FROM usuarios WHERE email = :email";
        $result = $this->db->executar($query, [':email' => $email]);
        
        if (!empty($result)) {
            throw new \Exception("Email já cadastrado");
        }

        // Insere o novo usuário
        $query = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $this->db->executar($query, [
            ':nome' => $nome,
            ':email' => $email,
            ':senha' => $senha
        ]);

        // Busca o usuário criado (sem a senha)
        $id = $this->db->getLastInsertId();
        return $this->buscarPorId($id);
    }

    public function listar() {
        $query = "SELECT id, nome, email FROM usuarios ORDER BY nome";
        return $this->db->executar($query);
    }

    public function buscarPorId($id) {
        $query = "SELECT id, nome, email FROM usuarios WHERE id = :id LIMIT 1";
        $result = $this->db->executar($query, [':id' => $id]);
        
        if (empty($result)) {
            throw new \Exception("Usuário não encontrado");
        }
        
        return $result[0];
    }

    public function atualizar($id, $nome, $email, $senha = null) {
        // Verifica se o usuário existe
        $this->buscarPorId($id);

        // Verifica se o novo email já existe em outro usuário
        $query = "SELECT id FROM usuarios WHERE email = :email AND id != :id";
        $result = $this->db->executar($query, [
            ':email' => $email,
            ':id' => $id
        ]);
        
        if (!empty($result)) {
            throw new \Exception("Email já cadastrado para outro usuário");
        }

        // Atualiza o usuário
        if ($senha) {
            $query = "UPDATE usuarios SET nome = :nome, email = :email, senha = :senha WHERE id = :id";
            $params = [
                ':nome' => $nome,
                ':email' => $email,
                ':senha' => $senha,
                ':id' => $id
            ];
        } else {
            $query = "UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id";
            $params = [
                ':nome' => $nome,
                ':email' => $email,
                ':id' => $id
            ];
        }

        $this->db->executar($query, $params);
        return $this->buscarPorId($id);
    }

    public function excluir($id) {
        // Verifica se o usuário existe
        $this->buscarPorId($id);

        // Exclui o usuário
        $query = "DELETE FROM usuarios WHERE id = :id";
        $this->db->executar($query, [':id' => $id]);
        return true;
    }
} 