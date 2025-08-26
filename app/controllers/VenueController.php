<?php
require_once __DIR__ . '/../models/Venue.php';
require_once __DIR__ . '/../models/Address.php'; // <-- Include the new Address model
require_once __DIR__ . '/../core/AuthHelper.php';

class VenueController
{

    /**
     * Display a list of all available venues.
     */
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
        require BASE_PATH . '/app/views/venues/create.php';
    }

    /**
     * Store a newly created venue and its address in the database.
     */
    public function store()
    {
        AuthHelper::check();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Passo 1: Obter o ID do usuário logado
            $userId = $_SESSION['user_id'];

            // Passo 2: Criar o registro de Endereço primeiro e obter seu novo ID
            // Corrigido para passar todos os argumentos que o Address::create espera
            $addressId = Address::create(
                $_POST['cep'],
                $_POST['street'],
                $_POST['number'],
                $_POST['neighborhood'],
                $_POST['complement'],
                $_POST['city'],
                $_POST['state']
            );

            // Passo 3: Criar o registro de Quadra usando o novo ID do endereço
            if ($addressId && Venue::create(
                $userId,
                $addressId,
                $_POST['name'],
                $_POST['average_price_per_hour'],
                $_POST['court_capacity'],
                $_POST['has_leisure_area'],
                $_POST['leisure_area_capacity'],
                $_POST['floor_type'],
                $_POST['has_lighting'],
                $_POST['is_covered']
                // status tem um valor padrão, então não precisamos passar
            )) {
                header('Location: ' . BASE_URL . '/quadras');
                exit;
            } else {
                // Lidar com erro potencial (ex: falha na criação do endereço)
                echo "Erro ao criar quadra ou endereço.";
            }
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
