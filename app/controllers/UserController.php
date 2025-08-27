    <?php
    require_once __DIR__ . '/../models/User.php';
    require_once __DIR__ . '/../core/AuthHelper.php';

    class UserController
    {

        public function dashboard()
        {
            // Apenas usuários logados podem acessar esta página
            AuthHelper::check();

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
                    header('Location: /colae/usuarios');
                    exit;
                } else {
                    header("Location: /colae/usuarios/editar/" . $_POST['id'] . "?status=erro");
                    exit;
                }
            }
        }

        public function delete($id)
        {
            AuthHelper::checkAdmin();
            if (User::delete($id)) {
                header("Location: /colae/usuarios");
                exit;
            } else {
                echo "Erro ao excluir usuário.";
            }
        }
    }
