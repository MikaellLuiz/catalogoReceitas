<?php
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

// Obter a rota da URL
$route = null;

// Primeiro tenta obter da query string (compatibilidade)
if (isset($_GET['route'])) {
    $route = $_GET['route'];
} 
// Depois tenta pelo PATH_INFO (URLs amigáveis)
elseif (isset($_SERVER['PATH_INFO'])) {
    $route = trim($_SERVER['PATH_INFO'], '/');
}
// Por último, tenta pelo REQUEST_URI
elseif (isset($_SERVER['REQUEST_URI'])) {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $route = trim($uri, '/');
    
    // Remove index.php da rota se presente
    if (strpos($route, 'index.php') === 0) {
        $route = trim(str_replace('index.php', '', $route), '/');
    }
}

// Se ainda tem parâmetro param (compatibilidade com sistema antigo)
if (!$route && isset($_GET["param"])) {
    $route = $_GET["param"];
}

// Processar a rota se existe
if ($route) {
    $controller = new Controller();
    $controller->verificarChamadas($route);
} else {
    // Retornar informações da API quando acessar a raiz
    $response = [
        'message' => 'API de Receitas - Catálogo do Apocalipse',
        'version' => '1.0',
        'endpoints' => [
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
        'base_url' => 'http://localhost:8080'
    ];
    
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
