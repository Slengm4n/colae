<?php

// Define o caminho base como o diretório *acima* do atual (ou seja, a raiz 'colae/')
define('BASE_PATH', dirname(__DIR__));

// Usa o BASE_PATH para incluir os ficheiros corretamente
require_once BASE_PATH . '/app/core/Router.php';
require_once BASE_PATH . '/app/controllers/UserController.php';
require_once BASE_PATH . '/app/controllers/SportController.php';
require_once BASE_PATH . '/app/controllers/AdminController.php';

$router = new Router();

// Página Inicial
$router->get('/', function () {
    require_once BASE_PATH . '/app/views/home.php';
});

$router->get('/admin', [AdminController::class, 'dashboard']);
$router->get('/', function() { header('Location: /login'); exit; });

$router->get('/login', [AuthController::class, 'index']);
$router->post('/login/authenticace', [AuthController::class, 'authenticate']);
$router->get('/logout', [AuthController::class, 'logout']);

// Rotas para Usuários
$router->get('/usuarios', [UserController::class, 'index']);
$router->get('/usuarios/criar', [UserController::class, 'create']);
$router->post('/usuarios/salvar', [UserController::class, 'store']);
$router->get('/usuarios/editar/{id}', [UserController::class, 'edit']);
$router->post('/usuarios/atualizar', [UserController::class, 'update']);
$router->get('/usuarios/excluir/{id}', [UserController::class, 'delete']);

// Rotas para esportes
$router->get('/esportes', [SportController::class,'index']);
$router->get('/esportes/criar', [SportController::class,'create']);
$router->post('/esportes/salvar', [SportController::class,'store']);
$router->get('/esportes/editar/{id}', [SportController::class,'edit']);
$router->post('/esportes/atualizar', [SportController::class,'update']);
$router ->get('/esportes/excluir/{id}', [SportController::class,'delete']);



// Executa o roteador
$router->dispatch();
