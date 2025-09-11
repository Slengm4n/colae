<?php

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Logger.php';

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
            Logger::getInstance()->critical('Extensão OpenSSL não está habilitada. Não é possível criptografar o CPF.');
            return false;
        }
        $encrypted = openssl_encrypt($cpf, 'aes-256-cbc', ENCRYPTION_KEY, 0, ENCRYPTION_IV);

        if ($encrypted === false) {
            Logger::getInstance()->critical('openssl_encrypt falhou. Verifique se ENCRYPTION_KEY e ENCRYPTION_IV estão corretas no config.php.');
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
            Logger::getInstance()->critical('Extensão OpenSSL não está habilitada. Não é possível descriptografar o CPF.');
            return false; // Retorna false em caso de falha
        }

        $decrypted = openssl_decrypt($encrypted_cpf, 'aes-256-cbc', ENCRYPTION_KEY, 0, ENCRYPTION_IV);

        if ($decrypted === false) {
            Logger::getInstance()->critical('openssl_decrypt falhou. O dado pode estar corrompido ou a chave/IV estão incorretos.');
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
            // O CPF será descriptografado no findById, então não precisamos mexer aqui
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

    public static function updatePassword($email, $password_hash)
    {
        $pdo = Database::getConnection();
        $sql = "UPDATE users SET password_hash = :password_hash WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['password_hash' => $password_hash, 'email' => $email]);
    }

    public static function deleteResetToken($token)
    {
        $pdo = Database::getConnection();
        $sql = "DELETE FROM password_resets WHERE token = :token";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['token' => $token]);
    }
}
