<?php

require_once __DIR__ . '/../core/Database.php';

class User
{
    //Variaveis publicas para armazenar os dados do usuario
    public $id;
    public $name;
    public $email;
    public $birthdate;
    public $role;
    public $cpf;

    // --- Funções de Criptografia ---

    private static function encryptCpf($cpf)
    {
        // Verifica se a extensão openssl está carregada
        if (!extension_loaded('openssl')) {
            return false;
        }
        $encrypted = openssl_encrypt($cpf, 'aes-256-cbc', ENCRYPTION_KEY, 0, hex2bin(ENCRYPTION_IV));

        if ($encrypted === false) {

            return false;
        }
        return $encrypted;
    }

    private static function decryptCpf($encrypted_cpf)
    {
        if (empty($encrypted_cpf)) {
            return null;
        }

        if (!extension_loaded('openssl')) {
            return false; // Retorna false em caso de falha
        }

        $decrypted = openssl_decrypt($encrypted_cpf, 'aes-256-cbc', ENCRYPTION_KEY, 0, hex2bin(ENCRYPTION_IV));

        if ($decrypted === false) {
            return false; // Retorna false em caso de falha
        }
        return $decrypted;
    }


    // --- Métodos do Usuário (Modificados para Criptografia) ---

    public static function findById($id)
    {
        $pdo = Database::getConnection();
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Descriptografa o CPF se ele existir
        if ($user && !empty($user['cpf'])) {
            $user['cpf'] = self::decryptCpf($user['cpf']);
        }

        return $user;
    }

    public static function updateCpf($userId, $cpf)
    {
        $encryptedCpf = self::encryptCpf($cpf);
        if ($encryptedCpf === false) {
            // A falha na criptografia já foi logada, retorna false para o controller
            return false;
        }
        $pdo = Database::getConnection();
        $query = "UPDATE users SET cpf = :cpf WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':cpf', $encryptedCpf);
        $stmt->bindParam(':id', $userId);
        return $stmt->execute();
    }

    public static function isCpfInUse($cpf, $excludeUserId)
    {
        $pdo = Database::getConnection();
        $query = "SELECT id, cpf FROM users WHERE id != :exclude_id AND cpf IS NOT NULL";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':exclude_id', $excludeUserId);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user) {
            if (self::decryptCpf($user['cpf']) === $cpf) {
                return true; // Encontrou um CPF igual
            }
        }
        return false;
    }

    // --- Métodos Originais (sem alteração) ---

    public static function getAll()
    {
        $pdo = Database::getConnection();
        $query = "SELECT * FROM users WHERE status = 'active' ORDER BY created_at DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Em /app/models/User.php

public static function create($name, $email, $birthdate, $password_hash, $role)
{
    $pdo = Database::getConnection();
    $query = "INSERT INTO users (name, email, birthdate, password_hash, role, status, force_password_change) VALUES (:name, :email, :birthdate, :password_hash, :role, 'active', 1)";
    $stmt = $pdo->prepare($query);

    // CORREÇÃO: Garanta que todas as variáveis aqui começam com $
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':birthdate', $birthdate);
    $stmt->bindParam(':password_hash', $password_hash);
    $stmt->bindParam(':role', $role);
    
    // A linha 123, que dava o erro, agora deve funcionar
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
            // O CPF será descriptografado no findById, então não precisamos mexer aqui
        }
        return $userData;
    }

    // Em /app/models/User.php

public function update()
{
    $pdo = Database::getConnection();
    
    // 1. A query deve incluir o campo 'role'
    $query = "UPDATE users SET name = :name, email = :email, birthdate = :birthdate, role = :role WHERE id = :id";
    
    $stmt = $pdo->prepare($query);
    
    // 2. Garanta que todos os 5 placeholders tenham um bindParam correspondente
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':birthdate', $this->birthdate);
    $stmt->bindParam(':role', $this->role); // Esta linha provavelmente estava faltando
    
    // A linha 162, que dava o erro, agora deve funcionar
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

    public static function findByEmail($email)
    {
        $pdo = Database::getConnection();
        $query = "SELECT * FROM users WHERE email = :email AND status = 'active'";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function savePasswordResetToken($email, $token, $expires_at)
    {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO password_resets (email, token, expires_at) VALUES (:email, :token, :expires_at)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email, 'token' => $token, 'expires_at' => $expires_at]);
    }

    public static function findResetToken($token)
    {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM password_resets WHERE token = :token";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

public static function updatePassword($userId, $password_hash)
{
    $pdo = Database::getConnection();
    // MUDANÇA AQUI: Usando 'id = :id' no WHERE
    $sql = "UPDATE users SET password_hash = :password_hash WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    
    // MUDANÇA AQUI: Passando o ID do usuário
    $stmt->execute(['password_hash' => $password_hash, 'id' => $userId]);
    
    return $stmt->rowCount() > 0;
}

    public static function deleteResetToken($token)
    {
        $pdo = Database::getConnection();
        $sql = "DELETE FROM password_resets WHERE token = :token";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['token' => $token]);
    }

    public static function clearPasswordChangeFlag($userId)
    {
        $pdo = Database::getConnection();
        $query = "UPDATE users SET force_password_change = 0 WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $userId);
        return $stmt->execute();
    }

    public static function updateFields($id, array $data)
    {
        if (empty($data)) {
            return true;
        }

        $pdo = Database::getConnection();

        $fields = [];
        foreach (array_keys($data) as $key) {
            $fields[] = "$key = :$key";
        }
        $query = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";

        $stmt = $pdo->prepare($query);

        foreach ($data as $key => &$value) {
            $stmt->bindParam(":$key", $value);
        }
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}
