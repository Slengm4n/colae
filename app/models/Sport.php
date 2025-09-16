<?php

require_once __DIR__ . '/../core/Database.php';

class Sport
{
    public $id;
    public $name;
    public $icon; // Adicionada propriedade para o ícone

    public static function getAll()
    {
        $pdo = Database::getConnection();
        // Garante que a coluna 'icon' está sendo selecionada
        $query = "SELECT id, name, icon, created_at, status FROM sports WHERE status = 'active' ORDER BY created_at DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($name, $icon)
    {
        $pdo = Database::getConnection();
        $query = "INSERT INTO sports (name, icon, status) VALUES (:name, :icon, 'active')";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":icon", $icon);
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
            $this->icon = $sportData['icon'] ?? null;
        }
        return $sportData;
    }


    // Em app/models/Sport.php

    public function update()
    {
        $pdo = Database::getConnection();

        // ALTERE A QUERY PARA INCLUIR O CAMPO 'icon'
        $query = 'UPDATE sports SET name = :name, icon = :icon WHERE id = :id';
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':icon', $this->icon); // <-- ADICIONE ESTA LINHA

        return $stmt->execute();
    }

    public static function delete($id)
    {
        $pdo = Database::getConnection();
        $query = "UPDATE sports SET status = 'inactive' WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
