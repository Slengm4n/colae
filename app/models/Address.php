<?php

namespace App\Models;

use App\Core\Database;

use PDO;

/**
 * Class Address
 * Gerencia todas as operações de banco de dados para a entidade de endereço,
 * incluindo a geocodificação para obter coordenadas.
 */
class Address
{
    /**
     * Cria um novo endereço no banco de dados, buscando as coordenadas geográficas.
     * @param array $data Dados do endereço.
     * @return string|false Retorna o ID do novo endereço ou false em caso de falha.
     */
    public static function create(array $data)
    {
        // --- Lógica de Geocodificação ---
        $latitude = null;
        $longitude = null;

        if (defined('GOOGLE_MAPS_API_KEY') && GOOGLE_MAPS_API_KEY) {
            $fullAddress = urlencode(
                "{$data['street']}, {$data['number']}, {$data['neighborhood']}, {$data['city']}, {$data['state']}, {$data['cep']}"
            );
            $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$fullAddress}&key=" . GOOGLE_MAPS_API_KEY;

            $responseJson = @file_get_contents($url);
            if ($responseJson) {
                $response = json_decode($responseJson);
                if ($response && $response->status == 'OK') {
                    $location = $response->results[0]->geometry->location;
                    $latitude = $location->lat;
                    $longitude = $location->lng;
                }
            }
        }
        // --- Fim da Geocodificação ---

        $pdo = Database::getConnection();
        $query = "INSERT INTO addresses (cep, street, `number`, neighborhood, complement, city, state, latitude, longitude) 
                  VALUES (:cep, :street, :number, :neighborhood, :complement, :city, :state, :latitude, :longitude)";

        $stmt = $pdo->prepare($query);

        // Adiciona as coordenadas ao array de dados para inserção
        $data['latitude'] = $latitude;
        $data['longitude'] = $longitude;

        if ($stmt->execute($data)) {
            return $pdo->lastInsertId();
        }

        return false;
    }

    /**
     * Busca um endereço pelo seu ID.
     * @param int $id
     * @return mixed
     */
    public static function findById(int $id)
    {
        $pdo = Database::getConnection();
        $query = "SELECT * FROM addresses WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Atualiza um endereço existente.
     * @param int $id
     * @param array $data
     * @return bool
     */
    public static function update(int $id, array $data): bool
    {
        if (empty($data)) {
            return true;
        }

        // Se o endereço for atualizado, podemos recalcular as coordenadas
        // (Esta parte é opcional, mas recomendada)
        // Você pode adicionar a lógica de geocodificação aqui também se desejar

        $pdo = Database::getConnection();
        $fields = [];
        foreach (array_keys($data) as $key) {
            // A palavra 'number' é reservada, então a escapamos com crases
            $fieldName = ($key === 'number') ? "`number`" : $key;
            $fields[] = "$fieldName = :$key";
        }
        $query = "UPDATE addresses SET " . implode(', ', $fields) . " WHERE id = :id";

        $stmt = $pdo->prepare($query);
        $data['id'] = $id;

        return $stmt->execute($data);
    }
}
