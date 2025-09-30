<?php
// Inicia a sessão para toda a aplicação.
// Esta linha deve ser a primeira coisa no seu script.
session_start();

//Mostrar todos os erros para depuração
ini_set('display_errors', 1);
error_reporting(E_ALL);

// --- Constantes e Configurações Globais ---
define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', '/colae'); // Ajuste se o seu projeto estiver noutra pasta
require_once BASE_PATH . '/config.php';

// --- Inclusão dos Controllers ---
require_once BASE_PATH . '/app/core/Router.php';
require_once BASE_PATH . '/app/controllers/HomeController.php';
require_once BASE_PATH . '/app/controllers/AuthController.php';
require_once BASE_PATH . '/app/controllers/UserController.php';
require_once BASE_PATH . '/app/controllers/VenueController.php';
require_once BASE_PATH . '/app/controllers/SportController.php';
require_once BASE_PATH . '/app/controllers/AdminController.php';


$router = new Router();

// --- ROTA PRINCIPAL ---
$router->get('/', [HomeController::class, 'index']);

// --- ROTAS DE AUTENTICAÇÃO ---
$router->get('/login', [AuthController::class, 'index']);
$router->post('/login/authenticate', [AuthController::class, 'authenticate']);
$router->get('/register', [AuthController::class, 'register']);
$router->post('/register/store', [AuthController::class, 'store']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/forgot-password', [AuthController::class, 'showForgotPasswordForm']);
$router->post('/forgot-password', [AuthController::class, 'sendResetLink']);
$router->get('/reset-password', [AuthController::class, 'showResetPasswordForm']);
$router->post('/reset-password', [AuthController::class, 'resetPassword']);


// --- ROTAS DO PAINEL DO USUÁRIO ---
$router->get('/dashboard', [UserController::class, 'dashboard']);
$router->get('/dashboard/cpf', [UserController::class, 'addCpf']);
$router->post('/dashboard/cpf', [UserController::class, 'storeCpf']);
$router->get('/dashboard/perfil', [UserController::class, 'profile']);
// ROTA CORRIGIDA PARA CORRESPONDER AO FORMULÁRIO:
$router->post('/dashboard/perfil/atualizar', [UserController::class, 'updateProfile']);


// --- ROTAS DE QUADRAS (VENUES) ---
$router->get('/quadras', [VenueController::class, 'index']);
$router->get('/quadras/criar', [VenueController::class, 'create']);
$router->post('/quadras/salvar', [VenueController::class, 'store']);
$router->get('/quadras/editar/{id}', [VenueController::class, 'edit']);
$router->post('/quadras/atualizar/{id}', [VenueController::class, 'update']);
$router->get('/quadras/excluir/{id}', [VenueController::class, 'delete']);


// --- ROTAS DO PAINEL ADMIN ---
$router->get('/admin', [AdminController::class, 'dashboard']);
$router->get('/admin/mapa', [AdminController::class, 'showMap']);
// Usuários (Admin)
$router->get('/admin/usuarios', [UserController::class, 'index']);
$router->get('/admin/usuarios/criar', [UserController::class, 'create']);
$router->post('/admin/usuarios/salvar', [UserController::class, 'store']);
$router->get('/admin/usuarios/editar/{id}', [UserController::class, 'edit']);
$router->post('/admin/usuarios/atualizar', [UserController::class, 'update']);
$router->get('/admin/usuarios/excluir/{id}', [UserController::class, 'delete']);
// Esportes (Admin)
$router->get('/admin/esportes', [SportController::class, 'index']);
$router->get('/admin/esportes/criar', [SportController::class, 'create']);
$router->post('/admin/esportes/salvar', [SportController::class, 'store']);
$router->get('/admin/esportes/editar/{id}', [SportController::class, 'edit']);
$router->post('/admin/esportes/atualizar', [SportController::class, 'update']);
$router->get('/admin/esportes/excluir/{id}', [SportController::class, 'delete']);


// Executa o roteador
$router->dispatch();
