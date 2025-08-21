
<?php
require_once __DIR__ . '/../models/Sport.php';

class SportController
{

    public function index()
    {
        $sports = Sport::getAll();
        require __DIR__ . '/../views/sports/index.php';
    }

    public function create()
    {
        require __DIR__ . '/../views/sports/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (Sport::create($_POST['name'])) {
                header('Location: /colae/esportes');
                exit;
            } else {
                echo "Erro ao criar esporte";
            }
        }
    }

    public function edit($id)
    {
        $sport = new Sport;
        $sportData = $sport->readOne($id);
        if ($sportData) {
            header("Location: /colae/esportes");
            exit;
        }
        require __DIR__ . "/../views/sports/edit.php";
    }

    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
            $sport = new Sport();
            $sport->id = $_POST['id'];
            $sport->name = $_POST['name'];

            if ($sport->update()) {
                header('Location: /colae/esportes');
                exit;
            } else {
                header('Location: /colae/esportes/editar/' . $_POST['id'] . "?status=erro");
                exit;
            }
        }
    }

    public function delete($id)
    {
        if (Sport::delete($id)) {
            header("Location: /colae/esportes");
            exit;
        } else {
            echo "Erro ao excluir usuario";
        }
    }
}
