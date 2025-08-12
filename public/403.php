<?php
http_response_code(403);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Acesso Negado</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        h1 { color: #d9534f; }
    </style>
</head>
<body>
    <h1>403 - Acesso Negado</h1>
    <p>Você não tem permissão para acessar esta página.</p>
    <a href="../index.php">Voltar à página inicial</a>
    
    <?php
    // Registrar o acesso negado
    require_once __DIR__ . '/../logs/logger.php';
    logMessage("Tentativa de acesso não autorizado: " . $_SERVER['REQUEST_URI'], 'SECURITY');
    ?>
</body>
</html>