<?php

namespace App\Controllers;

use App\Core\ImageHelper;
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
        $newAvatarFileName = null; // Variável para guardar o nome do novo arquivo

        // --- LÓGICA DO UPLOAD (ADICIONADA) ---
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {

            // Define o diretório CORRETO (sem /public/)
            $uploadDir = BASE_PATH . '/uploads/avatars/';

            // Chama o helper para processar e salvar (passando $userId para criar subpasta)
            $newAvatarFileName = ImageHelper::processAndSave($_FILES['avatar'], $uploadDir, $userId);

            if (!$newAvatarFileName) {
                // Se o upload falhar, redireciona com erro 
                // (Você pode criar uma mensagem mais específica no HTML depois)
                header('Location: ' . BASE_URL . '/dashboard/perfil?error=avatar_upload');
                exit;
            }
        }
        // --- FIM DA LÓGICA DO UPLOAD ---

        // Prepara os dados para atualizar no banco
        $updateData = [
            'name' => htmlspecialchars(trim($_POST['name'] ?? ''))
            // A data de nascimento é desabilitada no form, então não precisamos enviá-la
        ];

        if ($newAvatarFileName !== null) {
            $updateData['avatar_path'] = $newAvatarFileName;
            $oldUser = User::findById($userId);
            if ($oldUser && !empty($oldUser['avatar_path'])) {
                $oldAvatarFullPath = BASE_PATH . '/uploads/avatars/' . $userId . '/' . $oldUser['avatar_path'];
                if (file_exists($oldAvatarFullPath)) {
                    unlink($oldAvatarFullPath);
                }
            }
        }

        // Atualiza o usuário no banco de dados (array_filter remove valores vazios, se houver)
        if (User::update($userId, array_filter($updateData))) {
            // Atualiza o nome na sessão também, se mudou
            if (isset($updateData['name'])) {
                $_SESSION['user_name'] = $updateData['name'];
            }
            header('Location: ' . BASE_URL . '/dashboard/perfil?status=updated');
        } else {
            header('Location: ' . BASE_URL . '/dashboard/perfil?error=update_failed');
        }
        exit;
    }

    public function showSecurityPage()
    {
        AuthHelper::check();
        ViewHelper::render('users/security', ['userName' => $_SESSION['user_name'] ?? 'Utilizador']);
    }

    public function updatePasswordFromProfile()
    {
        AuthHelper::check(); // Garante que está logado

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // --- VALIDAÇÕES ---

            // 1. Busca o usuário atual para pegar o hash da senha
            $user = User::findById($userId);
            if (!$user) {
                // Se não encontrar o usuário (muito improvável), erro genérico
                header('Location: ' . BASE_URL . '/dashboard/perfil/seguranca?error=update_failed');
                exit;
            }

            // 2. Verifica se a senha ATUAL está correta (ESSENCIAL!)
            if (!password_verify($currentPassword, $user['password_hash'])) {
                header('Location: ' . BASE_URL . '/dashboard/perfil/seguranca?error=current_mismatch');
                exit;
            }

            // 3. Verifica se a nova senha e a confirmação coincidem
            if ($newPassword !== $confirmPassword) {
                header('Location: ' . BASE_URL . '/dashboard/perfil/seguranca?error=new_mismatch');
                exit;
            }

            // 4. (Opcional, mas recomendado) Verifica a força da nova senha
            if (strlen($newPassword) < 8) { // Exemplo: mínimo 8 caracteres
                // Crie essa mensagem 'weak_password' no HTML se quiser usá-la
                header('Location: ' . BASE_URL . '/dashboard/perfil/seguranca?error=weak_password');
                exit;
            }

            // --- ATUALIZAÇÃO ---

            // Se todas as validações passaram, hash a nova senha
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

            // Tenta atualizar no banco de dados
            if (User::update($userId, ['password_hash' => $newPasswordHash])) {
                // Sucesso! Redireciona com status=success
                header('Location: ' . BASE_URL . '/dashboard/perfil/seguranca?status=success');
            } else {
                // Falha ao salvar no banco
                header('Location: ' . BASE_URL . '/dashboard/perfil/seguranca?error=update_failed');
            }
            exit;
        }

        // Se não for POST, redireciona de volta
        header('Location: ' . BASE_URL . '/dashboard/perfil/seguranca');
        exit;
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
            } else {
                header('Location: ' . BASE_URL . '/admin/usuarios/criar?status=error_create');
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
