
<?php

require_once '../app/core/Database.php';

class Venue
{

    public $id;
    public $name;

    public $description;

    public $address;

    public $price_per_hour;

    public $court_capacity;

    public $play_area_capacity;

    public $floor_type;

    public $is_covered;


    public static function getAll()
    {
        $pdo = Database::getConnection();

        $query = "SELECT * FROM venues WHERE status = 'available'";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($name, $description, $address, $price_per_hour, $court_capacity, $play_area_capacity, $floor_type, $is_covered)
    {
        $pdo = Database::getConnection();

        $query = "INSERT INTO venues (name, description, address, price_per_hour, court_capacity, play_area_capacity, floor_type, is_covered, status) VALUES
        (:name, ;description, :address, :price_per_hour, :court_capacity, :play_area_capacity, :floor_type, is_covered, 'available')";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':price_per_hour', $price_per_hour);
        $stmt->bindParam(':court_capacity', $court_capacity);
        $stmt->bindParam(':play_area_capacity', $play_area_capacity);
        $stmt->bindParam(':floor_type', $floor_type);
        $stmt->bindParam(':is_covered', $is_covered);

        return $stmt->execute();
    }

    public function readOne($id)
    {
        $pdo = Database::getConnection();

        $query = "SELECT * FROM venues WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $venueData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($venueData) {
            $this->id = $venueData["id"];
            $this->name = $venueData["name"];
            $this->description = $venueData["description"];
            $this->address = $venueData["address"];
            $this->price_per_hour = $venueData["price_per_hour"];
            $this->court_capacity = $venueData["court_capacity"];
            $this->play_area_capacity = $venueData["play_area_capacity"];
            $this->floor_type = $venueData["floor_type"];
            $this->is_covered = $venueData["is_covered"];
        }

        return $venueData;
    }

    public function update()
    {
        $pdo = Database::getConnection();

        $query = "UPDATE venues SET name = :name, description = :description, address = :address, price_per_hour = :price_per_hour, court_capacity = :court_capacity, play_area_capacity = :play_area+capacity, floor_type = :floor_type, is_covered = :is_covered WHERE id = :id";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':price_per_hour', $this->price_per_hour);
        $stmt->bindParam(':court_capacity', $this->court_capacity);
        $stmt->bindParam(':play_area_capacity', $this->play_area_capacity);
        $stmt->bindParam(':floor_type', $this->floor_type);
        $stmt->bindParam(':is_covered', $this->is_covered);

        return $stmt->execute();
    }

    public static function delete($id)
    {

        $pdo = Database::getConnection();
        $query = "UPDATE venues SET status = 'unavaiable' WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }
}
