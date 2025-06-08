<?php

namespace generic;

use Exception;

class JwtHelper
{
    private static $secretKey = 'sua_chave_secreta_super_segura_jwt_2025_api_receitas';
    private static $algorithm = 'HS256';
    private static $expirationTime = 3600; // 1 hora em segundos

    /**
     * Gera um token JWT
     */
    public static function encode($payload)
    {
        try {
            $header = json_encode(['typ' => 'JWT', 'alg' => self::$algorithm]);
            
            // Adiciona informações padrão ao payload se não existirem
            if (!isset($payload['iat'])) {
                $payload['iat'] = time(); // Issued at
            }
            if (!isset($payload['exp'])) {
                $payload['exp'] = time() + self::$expirationTime; // Expiration time
            }
            
            $payload = json_encode($payload);
            
            $headerEncoded = self::base64UrlEncode($header);
            $payloadEncoded = self::base64UrlEncode($payload);
            
            $signature = hash_hmac('sha256', $headerEncoded . "." . $payloadEncoded, self::$secretKey, true);
            $signatureEncoded = self::base64UrlEncode($signature);
            
            return $headerEncoded . "." . $payloadEncoded . "." . $signatureEncoded;
            
        } catch (Exception $e) {
            throw new Exception("Erro ao gerar token JWT: " . $e->getMessage());
        }
    }

    /**
     * Decodifica e valida um token JWT
     */
    public static function decode($jwt)
    {
        try {
            $parts = explode('.', $jwt);
            
            if (count($parts) !== 3) {
                throw new Exception("Token JWT inválido");
            }
            
            $header = json_decode(self::base64UrlDecode($parts[0]), true);
            $payload = json_decode(self::base64UrlDecode($parts[1]), true);
            $signature = self::base64UrlDecode($parts[2]);
            
            // Verificar algoritmo
            if (!isset($header['alg']) || $header['alg'] !== self::$algorithm) {
                throw new Exception("Algoritmo JWT não suportado");
            }
            
            // Verificar assinatura
            $expectedSignature = hash_hmac('sha256', $parts[0] . "." . $parts[1], self::$secretKey, true);
            
            if (!hash_equals($expectedSignature, $signature)) {
                throw new Exception("Assinatura JWT inválida");
            }
            
            // Verificar expiração
            if (isset($payload['exp']) && $payload['exp'] < time()) {
                throw new Exception("Token JWT expirado");
            }
            
            return $payload;
            
        } catch (Exception $e) {
            throw new Exception("Erro ao decodificar token JWT: " . $e->getMessage());
        }
    }

    /**
     * Valida se um token JWT é válido
     */
    public static function validate($jwt)
    {
        try {
            self::decode($jwt);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Extrai o token Bearer do cabeçalho Authorization
     */
    public static function getBearerToken()
    {
        $headers = self::getAuthorizationHeader();
        
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        
        return null;
    }

    /**
     * Obtém o cabeçalho Authorization
     */
    private static function getAuthorizationHeader()
    {
        $headers = null;
        
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        
        return $headers;
    }

    /**
     * Codifica em Base64 URL-safe
     */
    private static function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Decodifica de Base64 URL-safe
     */
    private static function base64UrlDecode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
}
