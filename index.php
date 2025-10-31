<?php

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\VenueController;
use App\Controllers\SportController;
use App\Controllers\AdminController;
use App\Controllers\AuthApiController;
use App\Controllers\VenueApiController;
use App\Controllers\SportApiController;
use App\Controllers\GameApiController;


session_start();

// --- Constantes Globais ---
define('BASE_PATH', __DIR__);


/* --- Definição Dinâmica da BASE_URL --- */

// Detecta o protocolo (http ou https)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";

// Detecta o host (o domínio, ex: "localhost" ou "colae.42web.io")
$host = $_SERVER['HTTP_HOST'];

if ($host == 'localhost') {
    // --- AMBIENTE LOCAL (SEU PC) ---
    define('BASE_URL', 'http://localhost/colae');
    define('BASE_DIR_URL', '/colae');
} else {
    // --- AMBIENTE DE PRODUÇÃO ---
    define('BASE_URL', $protocol . '://' . $host);
    define('BASE_DIR_URL', '');
}

/* -------------------------------------- */


// --- Autoloader do Composer ---
require_once BASE_PATH . '/vendor/autoload.php';

// --- Configurações Personalizadas ---
require_once BASE_PATH . '/config.php';


// --- Instância do Roteador ---
$router = new Router();


// --- ROTAS PÚBLICAS ---
$router->get('/', [HomeController::class, 'index']);
$router->get('/login', [AuthController::class, 'index']);
$router->post('/login/authenticate', [AuthController::class, 'authenticate']);
$router->get('/register', [AuthController::class, 'register']);
$router->post('/register/store', [AuthController::class, 'store']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/forgot-password', [AuthController::class, 'showForgotPasswordForm']);
$router->post('/forgot-password', [AuthController::class, 'handleForgotPassword']);
$router->get('/reset-password', [AuthController::class, 'showResetForm']);
$router->post('/reset-password', [AuthController::class, 'handleResetPassword']);

// --- ROTAS DO PAINEL DO UTILIZADOR ---
$router->group('/dashboard', function ($router) {
    $router->get('/', [UserController::class, 'dashboard']);
    $router->get('/cpf', [UserController::class, 'addCpf']);
    $router->post('/cpf', [UserController::class, 'storeCpf']);
    $router->get('/perfil', [UserController::class, 'profile']);
    $router->post('/perfil/atualizar', [UserController::class, 'updateProfile']);
    $router->get('/perfil/seguranca', [UserController::class, 'showSecurityPage']);
    $router->post('/perfil/seguranca/atualizar', [UserController::class, 'updatePasswordFromProfile']);

    // --- ROTAS DE QUADRAS DO UTILIZADOR ---
    $router->group('/quadras', function ($router) {
        $router->get('/criar', [VenueController::class, 'create']);
        $router->post('/salvar', [VenueController::class, 'store']);
        $router->get('/editar/{id}', [VenueController::class, 'edit']);
        $router->post('/atualizar/{id}', [VenueController::class, 'update']);
        $router->post('/excluir/{id}', [VenueController::class, 'delete']);
    });
});


// --- ROTAS DO PAINEL DE ADMIN ---
$router->group('/admin', function ($router) {
    $router->get('/', [AdminController::class, 'dashboard']);
    $router->get('/mapa', [AdminController::class, 'showMap']);

    // Gerenciamento de Usuarios
    $router->group('/usuarios', function ($router) {
        $router->get('/', [UserController::class, 'index']);
        $router->get('/criar', [UserController::class, 'create']);
        $router->post('/salvar', [UserController::class, 'store']);
        $router->get('/editar/{id}', [UserController::class, 'edit']);
        $router->post('/atualizar', [UserController::class, 'update']);
        $router->post('/excluir/{id}', [UserController::class, 'delete']);
    });

    // Gerenciamento de eesportos
    $router->group('/esportes', function ($router) {
        $router->get('/', [SportController::class, 'index']);
        $router->get('/criar', [SportController::class, 'create']);
        $router->post('/salvar', [SportController::class, 'store']);
        $router->get('/editar/{id}', [SportController::class, 'edit']);
        $router->post('/atualizar', [SportController::class, 'update']);
        $router->post('/excluir/{id}', [SportController::class, 'delete']);
    });

    // --- ROTAS DE QUADRAS DO UTILIZADOR ---
    $router->group('/quadras', function ($router) {
        $router->get('/', [VenueController::class, 'index']);
        $router->get('/criar', [VenueController::class, 'create']);
        $router->post('/salvar', [VenueController::class, 'store']);
        $router->get('/editar/{id}', [VenueController::class, 'edit']);
        $router->post('/atualizar/{id}', [VenueController::class, 'update']);
        $router->post('/excluir/{id}', [VenueController::class, 'delete']);
    });
});

// --- ROTAS DA API V1 ---
$router->group('/api/v1', function ($router) {
    // Autenticação
    $router->post('/auth/login', [AuthApiController::class, 'login']);

    // Quadras (Venues)
    $router->get('/venues', [VenueApiController::class, 'getActiveVenuesForMap']);
    // $router->get('/venues/{id}', [VenueApiController::class, 'getVenueDetails']); // Exemplo futuro

    // Esportes
    $router->get('/sports', [SportApiController::class, 'getActiveSports']);

    // Partidas (Matches) - Requer autenticação
    $router->post('/games', [GameApiController::class, 'createGame']);
    // $router->get('/matches/venue/{venueId}', [MatchApiController::class, 'getMatches']); // Exemplo futuro
});


// Executa o roteador
$router->dispatch();
