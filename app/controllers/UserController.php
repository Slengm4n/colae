    <?php
    require_once __DIR__ . '/../models/User.php';
    require_once __DIR__ . '/../core/AuthHelper.php';

    class UserController
    {

        public function dashboard()
        {
            // Apenas usuários logados podem acessar esta página
            AuthHelper::check();
            $user = User::findById($_SESSION['user_id']);
            $_SESSION['user_cpf'] = $user['cpf'];
            // Carrega a view do painel do usuário
            require_once BASE_PATH . '/app/views/users/dashboard.php';
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
                    header('Location: /colae/usuarios');
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
                    Logger::getInstance()->info('CPF adicionado com sucesso.', ['user_id' => $userId]);
                    $_SESSION['user_cpf'] = $cpf; // Atualiza a sessão
                    header('Location: ' . BASE_URL . '/dashboard?status=cpf_success');
                    exit;
                } else {
                    Logger::getInstance()->error('Erro ao salvar CPF no banco de dados.', ['user_id' => $userId]);
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
