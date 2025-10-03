<?php

class AuthHelper
{

    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function check()
    {
        self::start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // !! A VERIFICAÇÃO PRINCIPAL !!
        // Se o usuário está marcado para trocar a senha...
        if (isset($_SESSION['force_password_change']) && $_SESSION['force_password_change'] == 1) {
            
            // ...e ele NÃO está tentando acessar a página de troca de senha ou o endpoint que salva a senha,
            // nós o redirecionamos para lá.
            $allowed_uris = [
                BASE_URL . '/perfil/alterar-senha',
                BASE_URL . '/perfil/salvar-nova-senha'
            ];

            if (!in_array($_SERVER['REQUEST_URI'], $allowed_uris)) {
                header('Location: ' . BASE_URL . '/perfil/alterar-senha');
                exit;
            }
        }
    }

    public static function checkAdmin()
    {
        self::check(); // A verificação acima será executada automaticamente aqui
        if ($_SESSION['user_role'] !== 'admin') {
            http_response_code(403);
            echo "<h1>Acesso Negado</h1><p>Você não tem permissão para acessar essa página!</p>";
            exit;
        }
    }
}