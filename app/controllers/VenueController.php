<?php
require_once __DIR__ . '/../models/Venue.php';
require_once __DIR__ . '/../models/Address.php'; // <-- Include the new Address model
require_once __DIR__ . '/../core/AuthHelper.php';
require_once __DIR__ . '/../core/ImageHelper.php';
require_once __DIR__ . '/../models/VenueImage.php';

class VenueController
{

    private function checkCpfStatus()
    {
        AuthHelper::check();
        if (empty($_SESSION['user_cpf'])) {
            // Se não tiver CPF, redireciona para o dashboard com uma mensagem
            header('Location: ' . BASE_URL . '/dashboard?error=cpf_required');
            exit;
        }
    }

    public function index()
    {
        AuthHelper::check();
        // Venue::getAll() now correctly joins the address data
        $venues = Venue::getAll();
        require BASE_PATH . '/app/views/venues/index.php';
    }

    /**
     * Show the form for creating a new venue.
     */
    public function create()
    {
        AuthHelper::check();
        $this->checkCpfStatus();
        require BASE_PATH . '/app/views/venues/create.php';
    }

    /**
     * Store a newly created venue and its address in the database.
     */
    public function store()
    {
        AuthHelper::check();
        $this->checkCpfStatus();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Passo 1: Salvar o endereço e obter o ID
            $addressId = Address::create(
                $_POST['cep'], $_POST['street'], $_POST['number'], $_POST['neighborhood'],
                $_POST['complement'] ?? null, $_POST['city'], $_POST['state']
            );

            if (!$addressId) {
                // Adicionar tratamento de erro (ex: redirecionar com mensagem)
                die("Erro fatal ao criar o endereço.");
            }

            // Passo 2: Salvar a quadra e obter o ID (requer a alteração no Venue::create)
            $venueId = Venue::create(
                $_SESSION['user_id'], $addressId, $_POST['name'], $_POST['average_price_per_hour'],
                $_POST['court_capacity'], $_POST['has_leisure_area'], $_POST['leisure_area_capacity'],
                $_POST['floor_type'], $_POST['has_lighting'], $_POST['is_covered']
            );
            
            if (!$venueId) {
                // Adicionar tratamento de erro
                die("Erro fatal ao criar a quadra.");
            }

            // --- Passo 3: PROCESSAR E SALVAR AS IMAGENS ---
            if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
                $uploadDir = BASE_PATH . "/public/uploads/venues/" . $venueId . "/";
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $imageCount = count($_FILES['images']['name']);
                for ($i = 0; $i < $imageCount; $i++) {
                    if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                        $tmpName = $_FILES['images']['tmp_name'][$i];
                        $originalName = $_FILES['images']['name'][$i];
                        $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

                        // Gera um nome de arquivo único
                        $newFileName = uniqid('venue_', true) . '.' . $fileExtension;
                        $destinationPath = $uploadDir . $newFileName;

                        // Otimiza e move a imagem usando o Helper
                        if (ImageHelper::optimize($tmpName, $destinationPath)) {
                            // Salva a referência no banco de dados usando o Model
                            VenueImage::create($venueId, $newFileName);
                        }
                    }
                }
            }

            // Passo 4: Redirecionar para a lista de quadras com sucesso
            header('Location: ' . BASE_URL . '/quadras');
            exit;
        }
    }

    /**
     * Show the form for editing a specific venue.
     * @param int $id The ID of the venue to edit.
     */
    public function edit($id)
    {
        AuthHelper::check();

        // Fetch the combined venue and address data to pre-fill the form
        $venue = Venue::readOne($id);

        if (!$venue) {
            // Handle case where venue doesn't exist
            echo "Quadra não encontrada.";
            exit;
        }

        // Pass the $venue data to the view
        require BASE_PATH . '/app/views/venues/edit.php';
    }

    /**
     * Update the specified venue and its address in the database.
     * @param int $id The ID of the venue to update.
     */
    public function update($id)
    {
        var_dump($_POST);
        die();

        AuthHelper::check();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Passo 1: Atualizar a tabela de Endereços
            $address = new Address();
            $address->id = $_POST['address_id']; // Vem do campo oculto do formulário
            $address->cep = htmlspecialchars($_POST['cep']);
            $address->street = htmlspecialchars($_POST['street']);
            $address->number = htmlspecialchars($_POST['number']);
            $address->neighborhood = htmlspecialchars($_POST['neighborhood']);
            $address->complement = htmlspecialchars($_POST['complement']);
            $address->city = htmlspecialchars($_POST['city']);
            $address->state = htmlspecialchars($_POST['state']);
            $addressUpdated = $address->update(); // Chama o método de atualização do Address

            // Passo 2: Atualizar a tabela de Quadras (Venue)
            $venue = new Venue();
            $venue->id = $id;
            // ... (resto dos campos da quadra) ...
            $venueUpdated = $venue->update();

            if ($venueUpdated && $addressUpdated) {
                header('Location: ' . BASE_URL . '/quadras');
                exit;
            } else {
                echo "Erro ao atualizar a quadra ou o endereço.";
            }
        }
    }

    /**
     * "Soft delete" the specified venue.
     * @param int $id The ID of the venue to delete.
     */
    public function delete($id)
    {
        AuthHelper::check();
        if (Venue::delete($id)) {
            header("Location: " . BASE_URL . '/quadras');
            exit;
        } else {
            echo "Erro ao excluir quadra";
        }
    }
}
