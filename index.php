<?php
require_once __DIR__ . '/vendor/autoload.php';
include "generic/Autoload.php";

use generic\Controller;
use generic\JWTManager;

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

// Lista de rotas que não precisam de autenticação
$publicRoutes = ['login', ''];

// Verificar autenticação para rotas protegidas
if (!in_array($route, $publicRoutes)) {
    try {
        $token = JWTManager::getTokenFromHeader();
        JWTManager::validateToken($token);
    } catch (\Exception $e) {
        http_response_code(401);
        echo json_encode([
            'error' => true,
            'message' => 'Acesso não autorizado: ' . $e->getMessage()
        ]);
        exit();
    }
}

// Processar a rota se existe
if (!empty($route)) {
    try {
        $controller = new Controller();
        $controller->verificarChamadas($route);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode([
            'error' => true,
            'message' => 'Erro interno do servidor: ' . $e->getMessage()
        ]);
    }
} else {
    // Retornar informações da API quando acessar a raiz
    $response = [
        'message' => 'API de Receitas - Catálogo do Apocalipse',
        'version' => '2.0',
        'description' => 'API RESTful para gerenciamento de receitas e ingredientes',
        'format' => 'Esta API aceita apenas URLs no formato RESTful',
        'endpoints' => [
            'POST /login' => 'Autenticar usuário e obter token JWT',
            'GET /receita' => 'Listar todas as receitas',
            'GET /receita/{id}' => 'Obter receita específica',
            'POST /receita' => 'Criar nova receita',
            'PUT /receita/{id}' => 'Atualizar receita',
            'DELETE /receita/{id}' => 'Excluir receita',
            'GET /ingrediente' => 'Listar todos os ingredientes',
            'GET /ingrediente/{id}' => 'Obter ingrediente específico',
            'POST /ingrediente' => 'Criar novo ingrediente',
            'PUT /ingrediente/{id}' => 'Atualizar ingrediente',
            'DELETE /ingrediente/{id}' => 'Excluir ingrediente',
            'GET /receita/{id}/ingredientes' => 'Listar ingredientes de uma receita',
            'POST /receita/{id}/ingredientes' => 'Adicionar ingrediente à receita',
            'DELETE /receita/{id}/ingredientes/{ingrediente_id}' => 'Remover ingrediente da receita'
        ],
        'examples' => [
            'POST /login - Autenticar e obter token',
            'GET /receita - Lista todas as receitas',
            'GET /receita/1 - Obtém a receita com ID 1',
            'POST /receita - Cria uma nova receita',
            'PUT /receita/1 - Atualiza a receita com ID 1',
            'DELETE /receita/1 - Exclui a receita com ID 1'
        ],
        'base_url' => 'http://localhost:8080'
    ];
    
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
