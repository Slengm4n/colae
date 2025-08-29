<?php

require_once __DIR__ . '/../../config.php'; 

class Database
{
    private static $pdo;

    public static function getConnection()
    {
        if (!isset(self::$pdo)) {
            $host = 'localhost';
            $dbname = 'colae_db';
            $user = 'root'; // ou seu usuário
            $pass = ''; // ou sua senha

            try {
                self::$pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); // Retorna objetos por padrão
            } catch (PDOException $e) {
                die("Erro de conexão com o banco de dados: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
