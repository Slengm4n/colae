<?php
require_once __DIR__ . '/../models/User.php';

class AuthController{
    

    public function index(){
        require __DIR__ . '/../views/auth/login.php';
    }

    public function authenticate(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = User::findByEmail($email);

            if($user && password_verify($password, $user['password_hash'])){
                session_start();

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];

            header ('Locaiton: /usuarios');
            exit;
        }else{
            $error = "Email ou senha inválidos";
            require __DIR__ . '/../views/auth/login.php';
        }

            }
        }

    public function logout(){
        session_start();
        session_unset();
        session_destroy;
        header(Location: /login);
        exit;
    }

    public function register()
    {
        require __DIR__ . '/../views/auth/register.php';
    }

    /**
     * Salva o novo usuário vindo do formulário de registro.
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Coleta e sanitiza os dados do formulário
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $birthdate = $_POST['birthdate'] ?? '';
            $password = $_POST['password'] ?? '';

            // 2. Validação básica
            if (empty($name) || empty($email) || empty($password) || empty($birthdate)) {
                $error = "Todos os campos são obrigatórios.";
                require __DIR__ . '/../views/auth/register.php';
                return;
            }

            // Valida o formato do e-mail
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "O formato do e-mail é inválido.";
                require __DIR__ . '/../views/auth/register.php';
                return;
            }

            // Verifica se o e-mail já existe no banco
            if (User::findByEmail($email)) {
                 $error = "Este e-mail já está cadastrado.";
                 require __DIR__ . '/../views/auth/register.php';
                 return;
            }

            // 3. Criptografa a senha (MUITO IMPORTANTE)
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // 4. Chama o Model para criar o usuário
            // A role padrão 'user' já é definida no banco de dados
            if (User::create($name, $email, $birthdate, $password_hash)) {
                // Se deu certo, redireciona para a página de login
                header('Location: /login?status=success');
                exit;
            } else {
                // Se deu errado, mostra a página de registro com um erro genérico
                $error = "Ocorreu um erro ao criar sua conta. Tente novamente.";
                require __DIR__ . '/../views/auth/register.php';
            }
        }
    }
}