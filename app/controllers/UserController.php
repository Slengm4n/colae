<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    public function index()
    {
        $users = User::getAll();
        require __DIR__ . '/../views/users/index.php';
    }

    public function create()
    {
        require __DIR__ . '/../views/users/create.php';
    }

    public function store()
    {
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
        if (User::delete($id)) {
            header("Location: /colae/usuarios");
            exit;
        } else {
            echo "Erro ao excluir usuário.";
        }
    }
}
