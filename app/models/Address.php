<?php

require_once __DIR__ . '/../core/Database.php';

class Address
{
    public $id;
    public $cep;
    public $street;
    public $number;
    public $neighborhood;
    public $complement;
    public $city;
    public $state;

    public static function create($cep, $street, $number, $neighborhood, $complement, $city, $state)
{
    // --- Início da Lógica de Geocodificação ---
    $apiKey = 'AIzaSyBQWIOMMnTnuoKmr9Qkvkfkaif45pzTSoE';
    $fullAddress = urlencode("$street, $number, $neighborhood, $city, $state, $cep");
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$fullAddress}&key={$apiKey}";

    $latitude = null;
    $longitude = null;

    // @ suprime erros caso a URL falhe; verificamos o resultado a seguir
    $responseJson = @file_get_contents($url);
    if ($responseJson) {
        $response = json_decode($responseJson);
        if ($response && $response->status == 'OK') {
            $location = $response->results[0]->geometry->location;
            $latitude = $location->lat;
            $longitude = $location->lng;
        }
    }
    // --- Fim da Lógica de Geocodificação ---

    $pdo = Database::getConnection();
    
    // Adicionamos latitude e longitude à query de inserção
    $query = "INSERT INTO addresses (cep, street, number, neighborhood, complement, city, state, latitude, longitude) 
              VALUES (:cep, :street, :number, :neighborhood, :complement, :city, :state, :latitude, :longitude)";
    
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":cep", $cep);
    $stmt->bindParam(":street", $street);
    $stmt->bindParam(":number", $number);
    $stmt->bindParam(":neighborhood", $neighborhood);
    $stmt->bindParam(":complement", $complement);
    $stmt->bindParam(":city", $city);
    $stmt->bindParam(":state", $state);
    $stmt->bindParam(":latitude", $latitude);
    $stmt->bindParam(":longitude", $longitude);

    $stmt->execute();
    return $pdo->lastInsertId();
}

    public static function readOne($id)
    {
        $pdo = Database::getConnection();
        $query = "SELECT * FROM addresses WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Atualiza um registro de endereço existente no banco de dados.
     */
    public function update()
    {
        $pdo = Database::getConnection();

        // Query corrigida para incluir todos os campos e sem erros de sintaxe
        $query = "UPDATE addresses SET 
                    cep = :cep, 
                    street = :street, 
                    `number` = :number, 
                    neighborhood = :neighborhood, 
                    complement = :complement, 
                    city = :city, 
                    state = :state
                  WHERE id = :id";
                  
        $stmt = $pdo->prepare($query);

        // Sintaxe do bindParam corrigida
        $stmt->bindParam(':cep', $this->cep);
        $stmt->bindParam(':street', $this->street);
        $stmt->bindParam(':number', $this->number);
        $stmt->bindParam(':neighborhood', $this->neighborhood);
        $stmt->bindParam(':complement', $this->complement);
        $stmt->bindParam(':city', $this->city);
        $stmt->bindParam(':state', $this->state);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
