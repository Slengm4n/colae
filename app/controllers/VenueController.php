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
    AuthHelper::check(); // Garante que o usuário está logado

    // O seu método readOne() já busca os dados da quadra e do endereço juntos, o que é perfeito.
    $venueData = Venue::readOne($id);

    // Garante que o local pertence ao usuário logado, por segurança.
    if (!$venueData || $venueData['user_id'] != $_SESSION['user_id']) {
        // Redireciona se o usuário tentar editar um local que não é seu
        header('Location: ' . BASE_URL . '/quadras?error=not_found');
        exit;
    }

    // Prepara os dados para a view
    $data = [
        'venue' => $venueData
    ];

    // Carrega a nova view de edição e passa os dados
    require_once BASE_PATH . '/app/views/venues/edit.php'; // Ajuste o caminho se necessário
}

    /**
     * Update the specified venue and its address in the database.
     * @param int $id The ID of the venue to update.
     */
    public function update($id)
{
    // Garante que o usuário está logado
    AuthHelper::check();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        try {
            // --- ETAPA 1: ATUALIZAR O ENDEREÇO ---
            // Você precisará de um modelo Address com um método update
            $address = new Address();
            $address->id = $_POST['address_id'];
            $address->cep = $_POST['cep'];
            $address->street = $_POST['street'];
            $address->number = $_POST['number'];
            $address->neighborhood = $_POST['neighborhood'];
            $address->city = $_POST['city'];
            $address->state = $_POST['state'];
            // Adicione a lógica de geocodificação aqui se necessário
            $address->update(); // Supondo que este método existe no seu Address.php

            // --- ETAPA 2: ATUALIZAR O LOCAL (VENUE) ---
            $venue = new Venue();
            $venue->id = $id; // O ID vem da URL
            $venue->name = $_POST['name'];
            $venue->average_price_per_hour = $_POST['average_price_per_hour'];
            $venue->court_capacity = $_POST['court_capacity'];
            $venue->floor_type = $_POST['floor_type'];
            $venue->has_leisure_area = $_POST['has_leisure_area'] ?? 0;
            $venue->leisure_area_capacity = $_POST['leisure_area_capacity'] ?? 0;
            $venue->has_lighting = $_POST['has_lighting'] ?? 0;
            $venue->is_covered = $_POST['is_covered'] ?? 0;
            $venue->status = $_POST['status'] ?? 'available';
            
            $venue->update(); // Usa o método update do seu Venue.php

            // ETAPA 3: PROCESSAR NOVAS IMAGENS (opcional, mas recomendado)
            // if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            //     // Lógica para apagar imagens antigas e salvar as novas...
            // }

            // --- ETAPA 4: REDIRECIONAR COM SUCESSO ---
            header('Location: ' . BASE_URL . '/quadras?status=updated_success');
            exit;

        } catch (Exception $e) {
            // Em caso de erro, redireciona de volta para a página de edição
            // error_log($e->getMessage()); // É uma boa prática logar o erro
            header('Location: ' . BASE_URL . '/quadras/editar/' . $id . '?status=error');
            exit;
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
