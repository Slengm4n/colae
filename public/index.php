<?php

require_once '../app/core/Router.php';
require_once '../app/controllers/UserController.php';
//Adicione outros controladores conforme necessário

//Define as rotas
$router = new Router();

//Rotas para Usuários
$router->get('/usuarios', [UserController::class, 'index']);
$router->get('/usuarios/criar', [UserController::class, 'create']);
$router->post('/usuarios/salvar', [UserController::class, 'store']);
$router->get('/usuarios/editar/{id}', [UserController::class, 'edit']);
$router->post('/usuarios/atualizar/{id}', [UserController::class, 'update']);
$router->get('/usuarios/excluir/{id}', [UserController::class, 'delete']);

$router->get('/', function () {
    echo "<h1>Página Inicial</h1><p>Bem-vindo ao sistema de gestão esportiva!</p>";
    echo "<a href='http://localhost/colae/usuarios'>Ver Usuários</a>";
});


//Executa o roteador
$router->dispatch();
