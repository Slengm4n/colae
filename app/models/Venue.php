<?php

require_once __DIR__ . '/../core/Database.php';

class Venue
{
    public $id;
    public $user_id;
    public $address_id;
    public $name;
    public $average_price_per_hour;
    public $court_capacity;
    public $has_leisure_area;
    public $leisure_area_capacity;
    public $floor_type;
    public $has_lighting;
    public $is_covered;
    public $status;
    public $created_at;
    public $updated_at;

    public static function findByUserId($userId)
    {
        $pdo = Database::getConnection();
        $query = "SELECT v.*, a.street, a.number,
                  -- Subquery para pegar apenas a primeira imagem de cada local
                  (SELECT vi.file_path FROM venue_images vi WHERE vi.venue_id = v.id ORDER BY vi.id ASC LIMIT 1) as image_path
                  FROM venues v
                  JOIN addresses a ON v.address_id = a.id
                  WHERE v.user_id = :user_id
                  ORDER BY v.created_at DESC";
                  
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getAll()
    {
        $pdo = Database::getConnection();
        $query = "SELECT v.*, a.street, a.number, a.city 
                  FROM venues v
                  JOIN addresses a ON v.address_id = a.id
                  WHERE v.status = 'available'";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($userId, $addressId, $name, $averagePricePerHour, $courtCapacity, $hasLeisureArea, $leisureAreaCapacity, $floorType, $hasLighting, $isCovered, $status = 'available')
    {
        $pdo = Database::getConnection();
        $query = "INSERT INTO venues (user_id, address_id, name, average_price_per_hour, court_capacity, has_leisure_area, leisure_area_capacity, floor_type, has_lighting, is_covered, status) 
                  VALUES (:user_id, :address_id, :name, :average_price_per_hour, :court_capacity, :has_leisure_area, :leisure_area_capacity, :floor_type, :has_lighting, :is_covered, :status)";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':address_id', $addressId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':average_price_per_hour', $averagePricePerHour);
        $stmt->bindParam(':court_capacity', $courtCapacity);
        $stmt->bindParam(':has_leisure_area', $hasLeisureArea);
        $stmt->bindParam(':leisure_area_capacity', $leisureAreaCapacity);
        $stmt->bindParam(':floor_type', $floorType);
        $stmt->bindParam(':has_lighting', $hasLighting);
        $stmt->bindParam(':is_covered', $isCovered);
        $stmt->bindParam(':status', $status);
        
        if ($stmt->execute()){
            return $pdo->lastInsertId();
        }
        return false;
    }

    public static function readOne($id)
    {
        $pdo = Database::getConnection();
        $query = "SELECT 
                    v.*, 
                    a.street, a.city, a.state, a.cep, a.number, a.neighborhood, a.complement
                  FROM venues v
                  JOIN addresses a ON v.address_id = a.id
                  WHERE v.id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAllWithCoordinates()
{
    $pdo = Database::getConnection();

    $query = "SELECT 
                v.id, 
                v.name, 
                a.street, 
                a.number, 
                a.city, 
                a.latitude, 
                a.longitude,
                vi.file_path AS image_path -- <== CAMPO DA IMAGEM ADICIONADO
              FROM venues v
              JOIN addresses a ON v.address_id = a.id
              -- Usamos LEFT JOIN para garantir que quadras sem imagem também apareçam
              LEFT JOIN venue_images vi ON v.id = vi.venue_id
              WHERE a.latitude IS NOT NULL AND a.longitude IS NOT NULL
              GROUP BY v.id"; // Agrupamos para pegar apenas uma imagem por quadra

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    /**
     * Atualiza um registro de quadra existente no banco de dados.
     */
    public function update()
    {
        $pdo = Database::getConnection();

        // Query correta para atualizar a tabela 'venues'
        $query = "UPDATE venues SET 
                    name = :name, 
                    average_price_per_hour = :average_price_per_hour, 
                    court_capacity = :court_capacity, 
                    has_leisure_area = :has_leisure_area, 
                    leisure_area_capacity = :leisure_area_capacity, 
                    floor_type = :floor_type, 
                    has_lighting = :has_lighting, 
                    is_covered = :is_covered,
                    status = :status
                  WHERE id = :id";
                  
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':average_price_per_hour', $this->average_price_per_hour);
        $stmt->bindParam(':court_capacity', $this->court_capacity);
        $stmt->bindParam(':has_leisure_area', $this->has_leisure_area);
        $stmt->bindParam(':leisure_area_capacity', $this->leisure_area_capacity);
        $stmt->bindParam(':floor_type', $this->floor_type);
        $stmt->bindParam(':has_lighting', $this->has_lighting);
        $stmt->bindParam(':is_covered', $this->is_covered);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function delete($id)
    {
        $pdo = Database::getConnection();
        $query = "UPDATE venues SET status = 'unavailable' WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
