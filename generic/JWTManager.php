<?php

namespace generic;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTManager {
    private static $secretKey = "chave_secreta_do_projeto_catalogo_receitas";
    private static $algorithm = 'HS256';

    public static function generateToken($userId, $email) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // Token válido por 1 hora

        $payload = array(
            "iat" => $issuedAt,
            "exp" => $expirationTime,
            "user_id" => $userId,
            "email" => $email
        );

        return JWT::encode($payload, self::$secretKey, self::$algorithm);
    }

    public static function validateToken($token) {
        try {
            $decoded = JWT::decode($token, new Key(self::$secretKey, self::$algorithm));
            return $decoded;
        } catch (\Exception $e) {
            throw new \Exception("Token inválido ou expirado");
        }
    }

    public static function getTokenFromHeader() {
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            throw new \Exception("Token não fornecido");
        }

        $authHeader = $headers['Authorization'];
        if (strpos($authHeader, 'Bearer ') !== 0) {
            throw new \Exception("Formato de token inválido");
        }

        return substr($authHeader, 7);
    }
} 