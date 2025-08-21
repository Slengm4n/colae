<?php
require_once __DIR__ . '/../models/User.php';
require_once '../app/core/Database.php';

class UserController
{



    public function index()
    {
        try {


            $users = User::getAll();

            require __DIR__ . '/../views/users/index.php';
        } catch (Exception $e) {
            error_log("Erro ao listar usuários: " . $e->getMessage());
            require __DIR__ . '/../views/error.php';
        }
    }

    public function create()
    {
        require __DIR__ . '/../views/users/create.php';
    }

    public function edit($id)
    {
        $pdo = Database::getConnection();

        $pdo->user->id = $id;

        if (!$pdo->user->readOne()) {
            header("Location: index.php?action=index");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdo->user->name = htmlspecialchars($_POST['name']);
            $pdo->user->email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $pdo->user->birthdate = $_POST['birthdate'];

            if ($pdo->user->update()) {
                header("Location: index.php?action=index");
                exit;
            } else {
                $error = "Erro ao atualizar usuário";
            }
        }
        require __DIR__ . '/../views/users/edit.php';
    }

    public function delete($id)
    {

        $pdo = Database::getConnection();

        $pdo->user->id = $id;
        if ($pdo->user->delete()) {
            header("Location: index.php?action=index");
            exit;
        } else {
            header("Location: index.php?action=index&error=delete_failed");
            exit;
        }
    }

    public function show($id)
    {
        $pdo = Database::getConnection();

        $pdo->user->id = $id;
        if ($pdo->user->readOne()) {
            require __DIR__ . '/../views/users/show.php';
        } else {
            header("Location: index.php?action=index");
            exit;
        }
    }

    //Função para salvar a requisição POST do formulário de cadastro
    public function store()
    {
        if (
            !isset($_POST['name']) || empty($_POST['name']) ||
            !isset($_POST['email']) || empty($_POST['email']) ||
            !isset($_POST['birthdate']) || empty($_POST['birthdate']) ||
            !isset($_POST['password']) || empty($_POST['password'])
        ) {
            echo "Todos os campos são obrigatórios.";
            return;
        }

        $name = $_POST['name'];
        $email = $_POST['email'];
        $birthdate = $_POST['birthdate'];
        $password = $_POST['password'];

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $success = User::create($name, $email, $birthdate, $password_hash);

        if ($success) {
            echo "Usuario criado com sucesso!";
            exit;
        } else {
            echo "Erro ao criar usuário.";
        }
    }
}
