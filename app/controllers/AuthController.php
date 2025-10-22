<?php

namespace App\Controllers;

use App\Core\ViewHelper;
use App\Models\User;
use DateTime;
use Exception;

class AuthController
{
    /*** Exibe o formulário de login.*/
    public function index()
    {
        // Renderiza a view usando a classe auxiliar
        ViewHelper::render('auth/login');
    }

    /*** Processa a tentativa de login.*/
    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = User::findByEmail($email);

            if ($user && password_verify($password, $user['password_hash'])) {
                // Inicia a sessão e armazena os dados
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];

                // Redireciona com base na role
                $redirect_to = ($user['role'] === 'admin') ? '/admin' : '/dashboard';
                header('Location: ' . BASE_URL . $redirect_to);
                exit;
            } else {
                // Falha no login
                header('Location: ' . BASE_URL . '/login?error=credentials');
                exit;
            }
        }
    }

    /*** Exibe o formulário de registro.*/
    public function register()
    {
        ViewHelper::render('auth/register');
    }

    /*** Processa o registro de um novo usuário.*/
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // --- VALIDAÇÃO ---
            if ($_POST['password'] !== $_POST['password_confirmation']) {
                header('Location: ' . BASE_URL . '/register?error=password_mismatch');
                exit;
            }
            if (!$this->isOver18($_POST['birthdate'])) {
                header('Location: ' . BASE_URL . '/register?error=underage');
                exit;
            }
            if (User::findByEmail($_POST['email'])) {
                header('Location: ' . BASE_URL . '/register?error=email_exists');
                exit;
            }

            // --- CORREÇÃO APLICADA AQUI ---
            // Agrupe os dados em um array associativo
            $userData = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'birthdate' => $_POST['birthdate'],
                'password_hash' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'role' => 'user' // Define a role padrão
            ];

            // Passe o array único para o método create
            if (User::create($userData)) {
                header('Location: ' . BASE_URL . '/login?status=registered');
                exit;
            } else {
                header('Location: ' . BASE_URL . '/register?error=generic');
                exit;
            }
        }
    }

    /*** Processa o logout do usuário.*/
    public function logout()
    {
        // A sessão já deve ter sido iniciada no index.php
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    /**
     * Verifica se a data de nascimento corresponde a mais de 18 anos.
     * @param string $birthdate
     * @return bool
     */
    private function isOver18($birthdate): bool
    {
        if (empty($birthdate)) {
            return false;
        }
        try {
            $birthDateObj = new DateTime($birthdate);
            $today = new DateTime();
            $age = $today->diff($birthDateObj);
            return $age->y >= 18;
        } catch (Exception $e) {
            return false;
        }
    }
}
