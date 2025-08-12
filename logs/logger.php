<?php
function logMessage($message, $level = 'INFO') {
    // Remove a duplicação da pasta logs no caminho
    $logFile = __DIR__ . '/app_' . date('Y-m-d') . '.log';
    $logMsg = '[' . date('Y-m-d H:i:s') . '] ' . $level . ': ' . $message . PHP_EOL;
    
    // Verifica e cria o diretório se não existir
    if (!file_exists(__DIR__)) {
        mkdir(__DIR__, 0755, true);
    }
    
    file_put_contents($logFile, $logMsg, FILE_APPEND);
}