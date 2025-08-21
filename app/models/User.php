
<?php

require_once '../app/core/Database.php';

class User
{

    public static function getAll()
    {
        $pdo = Database::getConnection();

        $query = ("SELECT * FROM users WHERE status = 'active' ORDER BY created_at DESC");
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function create($name, $email, $birthdate, $password_hash)
    {
        $pdo = Database::getConnection();

        $query = "INSERT INTO users (name, email, birthdate, password_hash, status) VALUES (:name, :email, :birthdate, :password_hash, 'active')";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':birthdate', $birthdate);
        $stmt->bindParam(':password_hash', $password_hash);

        return $stmt->execute();
    }

    public function readOne()
    {
        $pdo = Database::getConnection();

        $query = "SELECT * FROM WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $pdo->id);
        $stmt->execute();
    }

    public function update()
    {

        $pdo = Database::getConnection();

        $query = "UPDATE SET name = :name, email = :email, birthdate = :birthdate, role = :role WHERE id = :id";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':id', $pdo->id);
        $stmt->bindParam(':name', $pdo->name);
        $stmt->bindParam(':email', $pdo->email);
        $stmt->bindParam(':birthdate', $pdo->birthdate);

        return $pdo->execute();
    }

    public function delete()
    {

        $pdo = Database::getConnection();

        return $pdo->execute();
        $query = "UPDATE  SET status = 'inactive' WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $pdo->id);

        return $stmt->execute();
    }
}
