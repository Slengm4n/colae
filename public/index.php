<?php

//Mostrar todos os erros para depuração
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Define o caminho base como o diretório *acima* do atual (ou seja, a raiz 'colae/')
define('BASE_PATH', dirname(__DIR__));

define('BASE_URL', '/colae');

// Usa o BASE_PATH para incluir os ficheiros corretamente
require_once BASE_PATH . '/app/core/Router.php';
require_once BASE_PATH . '/app/controllers/UserController.php';
require_once BASE_PATH . '/app/controllers/SportController.php';
require_once BASE_PATH . '/app/controllers/AdminController.php';
require_once BASE_PATH . '/app/controllers/AuthController.php';

$router = new Router();

// Página Inicial
$router->get('/', function () {
    require_once BASE_PATH . '/app/views/home/index.php';
});

//Rotas de autenticação e registro
$router->get('/login', [AuthController::class, 'index']);
$router->post('/login/authenticate', [AuthController::class, 'authenticate']);
$router->get('/register', [AuthController::class, 'register']);
$router->post('/register/store', [AuthController::class, 'store']);
$router->get('/logout', [AuthController::class, 'logout']);

// --- ROTAS DE RECUPERAÇÃO DE SENHA ---
$router->get('/forgot-password', [AuthController::class, 'showForgotPasswordForm']);
$router->post('/forgot-password', [AuthController::class, 'sendResetLink']);
$router->get('/reset-password', [AuthController::class, 'showResetPasswordForm']);
$router->post('/reset-password', [AuthController::class, 'resetPassword']);

// --- ROTAS DO USUÁRIO ---
$router->get('/dashboard', [UserController::class, 'dashboard']);

// --- ROTAS DO PAINEL ADMIN ---
$router->get('/admin', [AdminController::class, 'dashboard']);

// Rotas para Usuários
$router->get('/usuarios', [UserController::class, 'index']);
$router->get('/usuarios/criar', [UserController::class, 'create']);
$router->post('/usuarios/salvar', [UserController::class, 'store']);
$router->get('/usuarios/editar/{id}', [UserController::class, 'edit']);
$router->post('/usuarios/atualizar', [UserController::class, 'update']);
$router->get('/usuarios/excluir/{id}', [UserController::class, 'delete']);

// Rotas para esportes
$router->get('/esportes', [SportController::class, 'index']);
$router->get('/esportes/criar', [SportController::class, 'create']);
$router->post('/esportes/salvar', [SportController::class, 'store']);
$router->get('/esportes/editar/{id}', [SportController::class, 'edit']);
$router->post('/esportes/atualizar', [SportController::class, 'update']);
$router->get('/esportes/excluir/{id}', [SportController::class, 'delete']);



// Executa o roteador
$router->dispatch();
