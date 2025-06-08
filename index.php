<?php
// Iniciar sessão para armazenar dados de autenticação
session_start();

include "generic/Autoload.php";

use generic\Controller;

// Configurar headers para API REST
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Lidar com requisições OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Obter a rota da URL no formato RESTful
$route = '';

// Extrair a rota do REQUEST_URI (URLs RESTful)
if (isset($_SERVER['REQUEST_URI'])) {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $route = trim($uri, '/');
    
    // Remove index.php da rota se presente
    if (strpos($route, 'index.php') === 0) {
        $route = trim(str_replace('index.php', '', $route), '/');
    }
}

// Processar a rota se existe
if (!empty($route)) {
    $controller = new Controller();
    $controller->verificarChamadas($route);
} else {
    // Retornar informações da API quando acessar a raiz
    $response = [
        'message' => 'API de Receitas - Catálogo do Apocalipse',
        'version' => '3.0',
        'description' => 'API RESTful para gerenciamento de receitas e ingredientes com autenticação JWT',
        'format' => 'Esta API aceita apenas URLs no formato RESTful',
        'authentication' => [
            'type' => 'JWT Bearer Token',
            'header' => 'Authorization: Bearer {token}',
            'public_endpoints' => ['POST /auth/login', 'POST /auth/registrar'],
            'protected_endpoints' => 'Todos os demais endpoints requerem autenticação'
        ],
        'endpoints' => [
            // Autenticação (Públicos)
            'POST /auth/login' => 'Fazer login e obter token JWT',
            'POST /auth/registrar' => 'Registrar novo usuário',
            'POST /auth/validar' => 'Validar token JWT',
            
            // Receitas (Protegidos - Requer token)
            'GET /receita' => 'Listar todas as receitas',
            'GET /receita/{id}' => 'Obter receita específica',
            'POST /receita' => 'Criar nova receita',
            'PUT /receita/{id}' => 'Atualizar receita',
            'DELETE /receita/{id}' => 'Excluir receita',
            
            // Ingredientes (Protegidos - Requer token)
            'GET /ingrediente' => 'Listar todos os ingredientes',
            'GET /ingrediente/{id}' => 'Obter ingrediente específico',
            'POST /ingrediente' => 'Criar novo ingrediente',
            'PUT /ingrediente/{id}' => 'Atualizar ingrediente',
            'DELETE /ingrediente/{id}' => 'Excluir ingrediente',
            
            // Receita-Ingredientes (Protegidos - Requer token)
            'GET /receita/{id}/ingredientes' => 'Listar ingredientes de uma receita',
            'POST /receita/{id}/ingredientes' => 'Adicionar ingrediente à receita',
            'DELETE /receita/{id}/ingredientes/{ingrediente_id}' => 'Remover ingrediente da receita'
        ],
        'examples' => [
            'Login' => 'POST /auth/login com {"email": "admin@exemplo.com", "senha": "password"}',
            'Usar token' => 'Header: Authorization: Bearer {token_recebido_no_login}',
            'GET /receita - Lista todas as receitas (requer token)',
            'GET /receita/1 - Obtém a receita com ID 1 (requer token)',
            'POST /receita - Cria uma nova receita (requer token)',
            'PUT /receita/1 - Atualiza a receita com ID 1 (requer token)',
            'DELETE /receita/1 - Exclui a receita com ID 1 (requer token)'
        ],
        'error_handling' => [
            'format' => 'Todos os erros retornam JSON com "erro", "codigo" e "timestamp"',
            '401' => 'Acesso não autorizado - Token inválido ou não fornecido',
            '400' => 'Dados inválidos',
            '500' => 'Erro interno do servidor'
        ],
        'base_url' => 'http://localhost:8080'
    ];
    
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
