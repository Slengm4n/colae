<?php

namespace App\Controllers;

use App\Core\AuthHelper;
use App\Core\ViewHelper;
use App\Models\User;
use App\Models\Venue;


class UserController
{


    public function dashboard()
    {
        AuthHelper::check();
        $userId = $_SESSION['user_id'];
        $user = User::findById($userId);

        $data = [
            'userName' => $_SESSION['user_name'] ?? 'Usuario',
            'userVenues' => Venue::findByUserId($userId),

            'showCpfModal' => empty($user['cpf'])
        ];

        ViewHelper::render('users/dashboard', $data);
    }

    public function profile()
    {
        AuthHelper::check();
        $data = [
            'userName' => $_SESSION['user_name'] ?? 'Usuario',
            'user' => User::findById($_SESSION['user_id'])
        ];
        ViewHelper::render('users/profile', $data);
    }

    public function updateProfile()
    {
        AuthHelper::check();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/dashboard/perfil');
            exit;
        }
        $userId = $_SESSION['user_id'];
        $updateData = [
            'name' => htmlspecialchars(trim($_POST['name'] ?? '')),
            'birthdate' => trim($_POST['birthdate'] ?? '')
        ];
        if (User::update($userId, array_filter($updateData))) {
            $_SESSION['user_name'] = $updateData['name'];
        }
        header('Location: ' . BASE_URL . '/dashboard/perfil?status=updated');
        exit;
    }

    public function showSecurityPage()
    {
        AuthHelper::check();
        ViewHelper::render('users/security', ['userName' => $_SESSION['user_name'] ?? 'Utilizador']);
    }

    public function updatePasswordFromProfile()
    {
        AuthHelper::check();
        // Adicione aqui a sua lógica de validação de senha
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $newPassword = $_POST['new_password'];
            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            User::update($userId, ['password_hash' => $passwordHash]);
            header('Location: ' . BASE_URL . '/dashboard/perfil/seguranca?status=success');
            exit;
        }
    }

    public function addCpf()
    {
        AuthHelper::check();
        ViewHelper::render('users/add_cpf', ['userName' => $_SESSION['user_name'] ?? 'Utilizador']);
    }

    public function storeCpf()
    {
        AuthHelper::check();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf'] ?? '');
            $userId = $_SESSION['user_id'];

            if (!$this->validateCpf($cpf)) {
                // Se o CPF for inválido, redireciona de volta com um erro para o popup.
                header('Location: ' . BASE_URL . '/dashboard?error=cpf_invalid');
                exit;
            }
            if (User::isCpfInUse($cpf, $userId)) {
                // Se o CPF já estiver em uso, redireciona com outro erro.
                header('Location: ' . BASE_URL . '/dashboard?error=cpf_in_use');
                exit;
            }
            if (User::update($userId, ['cpf' => $cpf])) {
                header('Location: ' . BASE_URL . '/dashboard?status=cpf_success');
                exit;
            }
        }
        // Se ocorrer um erro geral, redireciona.
        header('Location: ' . BASE_URL . '/dashboard?error=generic');
        exit;
    }


    // --- MÉTODOS DA ÁREA DO ADMINISTRADOR ---

    public function index()
    {
        AuthHelper::checkAdmin();
        $data = [
            'userName' => $_SESSION['user_name'] ?? 'Admin',
            'users' => User::getAll()
        ];
        ViewHelper::render('admin/index', $data);
    }

    public function create()
    {
        AuthHelper::checkAdmin();
        ViewHelper::render('admin/create', ['userName' => $_SESSION['user_name'] ?? 'Admin']);
    }

    public function store()
    {
        AuthHelper::checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $randomPassword = bin2hex(random_bytes(4));
            $data = [
                'name'      => trim($_POST['name']),
                'email'     => trim($_POST['email']),
                'birthdate' => $_POST['birthdate'],
                'role'      => in_array($_POST['role'], ['user', 'admin']) ? $_POST['role'] : 'user',
                'password_hash' => password_hash($randomPassword, PASSWORD_DEFAULT)
            ];
            if (User::create($data)) {
                $_SESSION['flash_message'] = ['type' => 'success_with_password', 'password' => $randomPassword];
                header('Location: ' . BASE_URL . '/admin/usuarios');
                exit;
            }
        }
        header('Location: ' . BASE_URL . '/admin/usuarios/criar?status=error');
        exit;
    }

    public function edit(int $id)
    {
        AuthHelper::checkAdmin();
        $userData = User::findById($id);

        if (!$userData) {
            header("Location: " . BASE_URL . "/admin/usuarios?status=not_found");
            exit;
        }
        $data = ['userName' => $_SESSION['user_name'] ?? 'Admin', 'userData' => $userData];
        ViewHelper::render('admin/edit', $data);
    }

    public function update()
    {
        AuthHelper::checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = (int)$_POST['id'];
            $data = [
                'name'      => trim($_POST['name']),
                'email'     => trim($_POST['email']),
                'birthdate' => $_POST['birthdate'],
                'role'      => $_POST['role']
            ];
            if (User::update($id, $data)) {
                header('Location: ' . BASE_URL . '/admin/usuarios?status=updated');
                exit;
            }
        }
        header('Location: ' . BASE_URL . '/admin/usuarios?status=error');
        exit;
    }

    public function delete(int $id)
    {
        AuthHelper::checkAdmin();
        if (User::delete($id)) {
            header("Location: " . BASE_URL . "/admin/usuarios?status=deleted");
        } else {
            header("Location: " . BASE_URL . "/admin/usuarios?status=error");
        }
        exit;
    }

    // --- MÉTODOS PRIVADOS DE AJUDA ---

    private function validateCpf(string $cpf): bool
    {
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);
        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) return false;
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) $d += $cpf[$c] * (($t + 1) - $c);
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) return false;
        }
        return true;
    }
}
