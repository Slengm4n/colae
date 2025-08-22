
<?php

require_once '../app/core/Database.php';

class User
{
    //Variaveis publicas para armazenar os dados do usuario
    public $id;
    public $name;
    public $email;
    public $birthdate;
    public $role;

    public static function getAll()
    {
        $pdo = Database::getConnection();

        $query = "SELECT * FROM users WHERE status = 'active' ORDER BY created_at DESC";
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

    public function readOne($id)
    {
        $pdo = Database::getConnection();

        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            $this->id = $userData['id'];
            $this->name = $userData['name'];
            $this->email = $userData['email'];
            $this->birthdate = $userData['birthdate'];
        }

        return $userData;
    }

    public function update()
    {

        $pdo = Database::getConnection();

        $query = "UPDATE users SET name = :name, email = :email, birthdate = :birthdate WHERE id = :id";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':birthdate', $this->birthdate);

        return $stmt->execute();
    }

    public static function delete($id)
    {
        $pdo = Database::getConnection();
        $query = "UPDATE users SET status = 'inactive' WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function findByEmail($email){

        $pdo = Database::getConnection();
        $query = "SELECT * FROM users WHERE email = :email AND status = 'active'";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email' , $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
