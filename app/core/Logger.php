<?php

// Importa as classes necessárias do Monolog
require_once BASE_PATH . '/vendor/autoload.php';

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

class Logger
{
    private static $instance = null;

    /**
     * Retorna uma instância única e pré-configurada do Logger (Padrão Singleton).
     *
     * @return MonologLogger
     */
    public static function getInstance(): MonologLogger
    {
        if (self::$instance === null) {
            // Cria um novo logger para o canal 'colae_app'
            self::$instance = new MonologLogger('colae_app');

            // Define o formato da linha de log
            // Ex: [2025-08-29 11:30:00] colae_app.INFO: Usuário logado com sucesso {"user_id":123} []
            $formatter = new LineFormatter(
                "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n",
                "Y-m-d H:i:s"
            );

            // Configura o handler para salvar os logs em um arquivo
            // Os logs serão salvos em logs/app.log
            $logFile = BASE_PATH . '/logs/app.log';
            $handler = new StreamHandler($logFile, MonologLogger::DEBUG); // Registra tudo a partir do nível DEBUG
            $handler->setFormatter($formatter);

            // Adiciona o handler ao logger
            self::$instance->pushHandler($handler);
        }

        return self::$instance;
    }
}
