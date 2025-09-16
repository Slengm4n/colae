<?php

require_once __DIR__ . '/../models/Sport.php';
require_once __DIR__ . '/../core/AuthHelper.php'; // Para verificação de admin

class SportController
{
    /**
     * Exibe a página de gerenciamento de esportes no painel de admin.
     */
    public function index()
    {
        AuthHelper::checkAdmin();
        try {
            $userName = $_SESSION['user_name'] ?? 'Admin';
            $allSports = Sport::getAll();
            $data = [
                'userName' => $userName,
                'sports' => $allSports
            ];
            // Carrega a view correta do painel de admin
            require __DIR__ . '/../views/sports/index.php';
        } catch (Exception $e) {
            echo "Erro ao carregar a página de esportes: " . $e->getMessage();
        }
    }

    /**
     * Exibe o formulário para criar um novo esporte.
     */
    public function create()
    {
        AuthHelper::checkAdmin();
        $userName = $_SESSION['user_name'] ?? 'Admin';
        $data = ['userName' => $userName];
        // Carrega a view de criação do painel de admin
        require __DIR__ . '/../views/sports/create.php';
    }

    /**
     * Salva o novo esporte no banco de dados.
     */
    public function store()
    {
        AuthHelper::checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['name']) && isset($_POST['icon'])) {
                if (Sport::create($_POST['name'], $_POST['icon'])) {
                    header('Location: ' . BASE_URL . '/admin/esportes?status=created_success');
                    exit;
                }
            }
            header('Location: ' . BASE_URL . '/admin/esportes?status=error');
            exit;
        }
    }

    /**
     * Exibe o formulário para editar um esporte existente.
     */
    public function edit($id)
    {
        AuthHelper::checkAdmin();
        $sport = new Sport;
        $sportData = $sport->readOne($id);

        if (!$sportData) {
            header("Location: " . BASE_URL . "/admin/esportes?status=not_found");
            exit;
        }

        $userName = $_SESSION['user_name'] ?? 'Admin';
        // AQUI ESTÁ O AJUSTE:
        $data = [
            'userName' => $userName,
            'sport' => $sportData // Envia os dados dentro da chave 'sport'
        ];

        // Certifique-se de que o caminho está correto
        require __DIR__ . "/../views/sports/edit.php";
    }


    /**
     * Atualiza um esporte no banco de dados.
     */
    // Em app/controllers/SportController.php

    public function update()
    {
        AuthHelper::checkAdmin();
        if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['id'])) {
            $sport = new Sport();
            $sport->id = $_POST['id'];
            $sport->name = htmlspecialchars($_POST['name']);
            $sport->icon = htmlspecialchars($_POST['icon']); // <-- ADICIONE ESTA LINHA

            if ($sport->update()) {
                header('Location: ' . BASE_URL . '/admin/esportes?status=updated_success');
                exit;
            } else {
                header('Location: ' . BASE_URL . '/admin/esportes/editar/' . $_POST['id'] . "?status=error");
                exit;
            }
        }
    }

    /**
     * Exclui (inativa) um esporte.
     */
    public function delete($id)
    {
        AuthHelper::checkAdmin();
        if (Sport::delete($id)) {
            header("Location: " . BASE_URL . "/admin/esportes?status=deleted_success");
            exit;
        } else {
            header("Location: " . BASE_URL . "/admin/esportes?status=error");
            exit;
        }
    }
}
