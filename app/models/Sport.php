
<?php

require_once '../app/core/Database.php';

class Sport
{

    //Variaveis publicas para armazenar os dados dos esportes

    public $id;
    public $name;

    public static function getAll()
    {

        $pdo = Database::getConnection();

        $query = "SELECT * FROM sports WHERE status = 'active' ORDER BY created_at DESC";
        $stmt = $pdo->prepare($query) ;
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($name)
    {
        $pdo = Database::getConnection();

        $query = "INSERT INTO sports (name, status) VALUES (:name, 'active')";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":name", $name);

        return $stmt->execute();
    }

    public function readOne($id)
    {

        $pdo = Database::getConnection();

        $query = "SELECT * FROM sports WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $sportData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($sportData) {
            $this->id = $sportData['id'];
            $this->name = $sportData['name'];
        }

        return $sportData;
    }

    public function update(){

        $pdo = Database::getConnection();

        $query = 'UPDATE sports SET name = :name WHERE id = :id';
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);

        return $stmt->execute();
    }

    public static function delete($id){
        $pdo = Database::getConnection();
        $query = "UPDATE sports SET status = 'inactive' WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }
}
