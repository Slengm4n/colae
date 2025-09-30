    <?php
    require_once __DIR__ . '/../models/User.php';
    require_once __DIR__ . '/../core/AuthHelper.php';

    class UserController
    {

        public function dashboard()
        {
            AuthHelper::check();

            // Busca o CPF do utilizador, se ainda não estiver na sessão
            if (!isset($_SESSION['user_cpf']) || empty($_SESSION['user_cpf'])) {
                $user = User::findById($_SESSION['user_id']);
                $_SESSION['user_cpf'] = $user['cpf'] ?? null;
            }

            // Busca os locais que pertencem ao utilizador logado
            $userVenues = Venue::findByUserId($_SESSION['user_id']);

            // Monta o array de dados para a view
            $data = [
                'userVenues' => $userVenues
            ];

            // Carrega a view do dashboard e passa os dados
            require_once BASE_PATH . '/app/views/users/dashboard.php';
        }


        public function profile()
        {
            AuthHelper::check();
            $userData = User::findById($_SESSION['user_id']);
            $data = [
                'user' => $userData
            ];
            require_once BASE_PATH . '/app/views/users/profile.php';
        }

        // Em /app/controllers/UserController.php

        // Em /app/controllers/UserController.php
        public function updateProfile()
        {
            AuthHelper::check();

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: ' . BASE_URL . '/dashboard/perfil');
                exit;
            }

            $userId = $_SESSION['user_id'];
            $currentUser = User::findById($userId);
            $updateData = [];

            // 1. Processa os dados de texto
            if (isset($_POST['name']) && $_POST['name'] !== $currentUser['name']) {
                // Sintaxe compatível para htmlspecialchars
                $updateData['name'] = htmlspecialchars($_POST['name']);
            }
            if (isset($_POST['birthdate']) && $_POST['birthdate'] !== $currentUser['birthdate']) {
                $updateData['birthdate'] = $_POST['birthdate'];
            }

            // 2. Processa o upload do avatar
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['avatar'];
                $uploadDir = BASE_PATH . '/public/uploads/avatars/';

                // Validações
                if ($file['size'] > 10 * 1024 * 1024) { // 10MB
                    $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Arquivo muito grande! (Máx 10MB)'];
                    header('Location: ' . BASE_URL . '/dashboard/perfil');
                    exit;
                }

                // Gera um nome único para o arquivo para evitar sobreescrever arquivos
                $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $newFileName = uniqid('avatar_', true) . '.' . $fileExtension;
                $destination = $uploadDir . $newFileName;

                // Tenta mover o novo arquivo (Sintaxe compatível)
                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    // Se o upload deu certo, apaga o arquivo de avatar antigo (se existir)
                    if (!empty($currentUser['avatar_path']) && file_exists($uploadDir . $currentUser['avatar_path'])) {
                        unlink($uploadDir . $currentUser['avatar_path']);
                    }
                    // Adiciona o novo nome do arquivo para ser salvo no banco
                    $updateData['avatar_path'] = $newFileName;
                } else {
                    $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Falha ao fazer upload da imagem.'];
                    header('Location: ' . BASE_URL . '/dashboard/perfil');
                    exit;
                }
            }

            // 3. Atualiza o banco de dados (se houver algo para atualizar)
            if (!empty($updateData)) {
                if (User::updateFields($userId, $updateData)) {
                    $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Perfil atualizado com sucesso!'];
                    if (isset($updateData['name'])) {
                        $_SESSION['user_name'] = $updateData['name'];
                    }
                } else {
                    $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Erro ao salvar os dados no banco.'];
                }
            }

            // 4. Redireciona de volta para a página de perfil
            header('Location: ' . BASE_URL . '/dashboard/perfil');
            exit;
        }

        public function index()
        {
            AuthHelper::check();
            $users = User::getAll();
            require BASE_PATH . '/app/views/users/index.php';
        }

        public function create()
        {
            AuthHelper::checkAdmin();
            require __DIR__ . '/../views/users/create.php';
        }

        public function store()
        {
            AuthHelper::checkAdmin();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                if (User::create($_POST['name'], $_POST['email'], $_POST['birthdate'], $password_hash)) {
                    header('Location: ' . BASE_URL . '/admin/usuarios');
                    exit;
                } else {
                    echo "Erro ao criar usuário.";
                }
            }
        }

        public function addCpf()
        {
            AuthHelper::check();
            require_once BASE_PATH . '/app/views/users/add_cpf.php';
        }

        public function storeCpf()
        {
            AuthHelper::check();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $cpf = $_POST['cpf'] ?? '';
                $userId = $_SESSION['user_id'];

                // Valida o CPF
                if (!$this->validateCpf($cpf)) {
                    $error = "CPF inválido. Por favor, verifique o número digitado.";
                    require_once BASE_PATH . '/app/views/users/add_cpf.php';
                    return;
                }

                // Remove a formatação para salvar no banco
                $cpf = preg_replace('/[^0-9]/', '', $cpf);

                // Verifica se o CPF já está em uso por outro usuário
                if (User::isCpfInUse($cpf, $userId)) {
                    $error = "Este CPF já está cadastrado em outra conta.";
                    require_once BASE_PATH . '/app/views/users/add_cpf.php';
                    return;
                }

                // Salva o CPF no banco de dados
                if (User::updateCpf($userId, $cpf)) {
                    $_SESSION['user_cpf'] = $cpf; // Atualiza a sessão
                    header('Location: ' . BASE_URL . '/dashboard?status=cpf_success');
                    exit;
                } else {
                    $error = "Ocorreu um erro ao salvar seu CPF. Tente novamente.";
                    require_once BASE_PATH . '/app/views/users/add_cpf.php';
                }
            }
        }

        private function validateCpf($cpf): bool
        {
            // Remove caracteres especiais
            $cpf = preg_replace('/[^0-9]/is', '', $cpf);

            // Verifica se o número de dígitos é 11
            if (strlen($cpf) != 11) {
                return false;
            }

            // Verifica se todos os dígitos são iguais (ex: 111.111.111-11)
            if (preg_match('/(\d)\1{10}/', $cpf)) {
                return false;
            }

            // Calcula os dígitos verificadores
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    return false;
                }
            }
            return true;
        }


        public function edit($id)
        {
            AuthHelper::checkAdmin();
            $user = new User();
            $userData = $user->readOne($id);
            if (!$userData) {
                header("Location: /colae/usuarios");
                exit;
            }
            require __DIR__ . '/../views/users/edit.php';
        }

        public function update()
        {
            AuthHelper::checkAdmin();
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
                $user = new User();
                $user->id = $_POST['id'];
                $user->name = htmlspecialchars($_POST['name']);
                $user->email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $user->birthdate = $_POST['birthdate'];

                if ($user->update()) {
                    header('Location: /colae/admin/usuarios');
                    exit;
                } else {
                    header("Location: /colae/admin/usuarios/editar/" . $_POST['id'] . "?status=erro");
                    exit;
                }
            }
        }

        public function delete($id)
        {
            AuthHelper::checkAdmin();
            if (User::delete($id)) {
                header("Location: /colae/admin/usuarios");
                exit;
            } else {
                echo "Erro ao excluir usuário.";
            }
        }
    }
