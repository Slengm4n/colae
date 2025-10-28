<?php

namespace App\Controllers;

use App\Core\AuthHelper;
use App\Core\ViewHelper;
use App\Models\Venue;
use App\Models\User;
use App\Models\Address;
use App\Models\VenueImage;

class VenueController
{
    /*** Exibe a lista de quadras do usuário logado.*/
    public function index()
    {
        AuthHelper::check();
        $venues = Venue::findByUserId($_SESSION['user_id']);

        $data = [
            'userName' => $_SESSION['user_name'] ?? 'Usuário',
            'venues' => $venues
        ];

        ViewHelper::render('venues/index', $data);
    }

    /*** Exibe o formulário para criar uma nova quadra.*/
    public function create()
    {
        $this->checkCpfStatus();
        $data = ['userName' => $_SESSION['user_name'] ?? 'Usuário'];
        ViewHelper::render('venues/create', $data);
    }

    /*** Salva uma nova quadra, seu endereço e suas imagens no banco de dados.*/
    public function store()
    {
        $this->checkCpfStatus();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Cria o endereço e obtém o ID
            $addressData = [
                'cep' => $_POST['cep'],
                'street' => $_POST['street'],
                'number' => $_POST['number'],
                'neighborhood' => $_POST['neighborhood'],
                'complement' => $_POST['complement'] ?? null,
                'city' => $_POST['city'],
                'state' => $_POST['state']
            ];
            $addressId = Address::create($addressData);

            if (!$addressId) {
                // Tratar erro de criação de endereço
                header('Location: ' . BASE_URL . '/quadras/criar?status=address_error');
                exit;
            }

            // 2. Cria a quadra usando o ID do endereço
            $venueData = [
                'user_id' => $_SESSION['user_id'],
                'address_id' => $addressId,
                'name' => $_POST['name'],
                'average_price_per_hour' => $_POST['average_price_per_hour'],
                'court_capacity' => $_POST['court_capacity'],
                'has_leisure_area' => $_POST['has_leisure_area'] ?? 0,
                'leisure_area_capacity' => $_POST['leisure_area_capacity'] ?? null,
                'floor_type' => $_POST['floor_type'],
                'has_lighting' => $_POST['has_lighting'] ?? 0,
                'is_covered' => $_POST['is_covered'] ?? 0
            ];
            $venueId = Venue::create($venueData);

            if (!$venueId) {
                // Tratar erro de criação de quadra
                header('Location: ' . BASE_URL . '/quadras/criar?status=venue_error');
                exit;
            }

            // 3. Processa e salva as imagens
            if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
                $this->handleImageUploads($venueId);
            }

            header('Location: ' . BASE_URL . '/dashboard?status=venue_created');
            exit;
        }
    }

    /**
     * Exibe o formulário para editar uma quadra.
     * @param int $id
     */
    public function edit(int $id)
    {
        AuthHelper::check();
        $venue = Venue::findById($id);

        // Validação de segurança: o usuário só pode editar suas próprias quadras
        if (!$venue || $venue['user_id'] != $_SESSION['user_id']) {
            header('Location: ' . BASE_URL . '/dashboard?error=not_found');
            exit;
        }

        $data = [
            'userName' => $_SESSION['user_name'] ?? 'Usuário',
            'venue' => $venue
        ];
        ViewHelper::render('venues/edit', $data);
    }

    /**
     * Atualiza uma quadra e seu endereço.
     * @param int $id
     */
    public function update(int $id)
    {
        AuthHelper::check();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validação de segurança
            $venue = Venue::findById($id);
            if (!$venue || $venue['user_id'] != $_SESSION['user_id']) {
                header('Location: ' . BASE_URL . '/dashboard?error=unauthorized');
                exit;
            }

            // 1. Atualiza o endereço
            $addressData = [
                'cep' => $_POST['cep'],
                'street' => $_POST['street'],
                'number' => $_POST['number'],
                'neighborhood' => $_POST['neighborhood'],
                'complement' => $_POST['complement'] ?? null,
                'city' => $_POST['city'],
                'state' => $_POST['state']
            ];
            Address::update((int)$_POST['address_id'], $addressData);

            // 2. Atualiza a quadra
            $venueData = [
                'name' => $_POST['name'],
                'average_price_per_hour' => $_POST['average_price_per_hour'],
                'court_capacity' => $_POST['court_capacity'],
                'has_leisure_area' => $_POST['has_leisure_area'] ?? 0,
                'leisure_area_capacity' => $_POST['leisure_area_capacity'] ?? null,
                'floor_type' => $_POST['floor_type'],
                'has_lighting' => $_POST['has_lighting'] ?? 0,
                'is_covered' => $_POST['is_covered'] ?? 0,
                'status' => $_POST['status'] ?? 'available'
            ];
            Venue::update($id, $venueData);

            // --- INÍCIO DA LÓGICA DE IMAGEM ---

            // 3. Deleta imagens marcadas para exclusão
            if (isset($_POST['delete_images']) && is_array($_POST['delete_images'])) {
                $uploadDir = BASE_PATH . "/uploads/venues/" . $id . "/";

                foreach ($_POST['delete_images'] as $imageId) {
                    // Assumindo que VenueImage::findById() existe e retorna a imagem
                    $image = VenueImage::findById((int)$imageId); 
                    
                    if ($image) {
                        // Deleta o arquivo físico do servidor
                        // Assumindo que o banco guarda o nome do arquivo na coluna 'file_name' ou 'url'
                        $fileName = $image['file_name'] ?? $image['url']; 
                        $filePath = $uploadDir . $fileName;
                        
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }

                        // Deleta o registro do banco de dados
                        // Assumindo que VenueImage::delete() existe
                        VenueImage::delete((int)$imageId);
                    }
                }
            }

            // 4. Lógica para upload de novas imagens (reutilizando sua função)
            if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
                $this->handleImageUploads($id);
            }
            
            // --- FIM DA LÓGICA DE IMAGEM ---


            header('Location: ' . BASE_URL . '/dashboard?status=venue_updated');
            exit;
        }
    }

    /**
     * Deleta (soft delete) uma quadra.
     * @param int $id
     */
    public function delete(int $id)
    {
        AuthHelper::check();
        // Validação de segurança
        $venue = Venue::findById($id);
        if (!$venue || $venue['user_id'] != $_SESSION['user_id']) {
            header('Location: ' . BASE_URL . '/dashboard?error=unauthorized');
            exit;
        }

        if (Venue::delete($id)) {
            header("Location: " . BASE_URL . "/dashboard?status=deleted");
        } else {
            header("Location: " . BASE_URL . "/dashboard?status=error");
        }
        exit;
    }


    // --- MÉTODOS PRIVADOS DE AJUDA ---

    /**
     * Verifica se o usuário tem um CPF cadastrado, redirecionando caso não tenha.
     */
    private function checkCpfStatus()
    {
        AuthHelper::check();
        $user = User::findById($_SESSION['user_id']);
        if (empty($user['cpf'])) {
            header('Location: ' . BASE_URL . '/dashboard?error=cpf_required');
            exit;
        }
    }

    /**
     * Processa o upload de múltiplas imagens para uma quadra.
     * @param int $venueId
     */
    private function handleImageUploads(int $venueId)
    {
        // Linha 203 (CORRIGIDA)
        $uploadDir = BASE_PATH . "/uploads/venues/" . $venueId . "/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $imageCount = count($_FILES['images']['name']);
        for ($i = 0; $i < $imageCount; $i++) {
            if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['images']['tmp_name'][$i];
                $originalName = $_FILES['images']['name'][$i];
                $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                $newFileName = uniqid('venue_', true) . '.' . $fileExtension;
                $destinationPath = $uploadDir . $newFileName;

                // Aqui você pode adicionar a otimização de imagem se tiver um ImageHelper
                if (move_uploaded_file($tmpName, $destinationPath)) {
                    // Salva apenas o NOME DO ARQUIVO no banco
                    VenueImage::create($venueId, $newFileName);
                }
            }
        }
    }
}