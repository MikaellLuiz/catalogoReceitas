<?php

namespace generic;

use generic\JwtHelper;
use Exception;

class AuthMiddleware
{
    /**
     * Verifica se a requisição possui um token JWT válido
     */
    public static function verificarAutenticacao()
    {
        try {
            $token = JwtHelper::getBearerToken();
            
            if (!$token) {
                return self::retornarErroAutorizacao("Token não fornecido");
            }
            
            $payload = JwtHelper::decode($token);
            
            // Armazenar dados do usuário na sessão para uso posterior
            $_SESSION['usuario_autenticado'] = $payload;
            
            return true;
            
        } catch (Exception $e) {
            return self::retornarErroAutorizacao("Token inválido: " . $e->getMessage());
        }
    }

    /**
     * Retorna resposta de erro de autorização
     */
    private static function retornarErroAutorizacao($mensagem = "Acesso não autorizado")
    {
        http_response_code(401);
        header('Content-Type: application/json; charset=utf-8');
        
        $erro = [
            'erro' => $mensagem,
            'codigo' => 401,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        echo json_encode($erro, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit();
    }

    /**
     * Obtém os dados do usuário autenticado
     */
    public static function getUsuarioAutenticado()
    {
        return $_SESSION['usuario_autenticado'] ?? null;
    }

    /**
     * Verifica se o usuário está autenticado
     */
    public static function estaAutenticado()
    {
        return isset($_SESSION['usuario_autenticado']);
    }
}
