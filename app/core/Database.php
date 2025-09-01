<?php

// Inclui o arquivo de configuração que carrega as variáveis de ambiente e define as constantes.
require_once __DIR__ . '/../../config.php';

class Database
{
    /**
     * @var PDO|null A instância única da conexão PDO (padrão Singleton).
     */
    private static $pdo;

    /**
     * Obtém a conexão com o banco de dados.
     * Se a conexão ainda não existir, ela é criada.
     *
     * @return PDO A instância da conexão PDO.
     */
    public static function getConnection()
    {
        // Verifica se a conexão já foi instanciada
        if (!isset(self::$pdo)) {
            try {
                // Cria a nova instância PDO usando as constantes definidas no config.php
                self::$pdo = new PDO(
                    "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
                    DB_USER,
                    DB_PASS
                );

                // Define os atributos do PDO para um tratamento de erros mais robusto
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            } catch (PDOException $e) {
                // Em caso de falha na conexão, encerra a execução e exibe uma mensagem clara.
                // Em um ambiente de produção, o ideal seria logar este erro em vez de exibi-lo na tela.
                die("Erro de conexão com o banco de dados: " . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
