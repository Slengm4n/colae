<?php

require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../../logs/logger.php';
require_once __DIR__ . '/../../config/database/db.php';

if ($_SESSION['user_role'] !== 'admin') {
    logMessage("Tentativa de acesso não autorizado ao dashboard", 'SECURITY');
    header('Location: /public/403.php');
    exit;
}

// Verifica se o ID do usuário foi passado via GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    logMessage("Tentativa de exclusão de usuário sem ID.", 'WARN');
    header("Location: ./users/index.php"); // Redireciona de volta para a lista
    exit();
}

$userId = $_GET['id'];

try {
    // Prepara a query para excluir o usuário com base no ID
    // O ponto de interrogação '?' é o placeholder para o parâmetro
    $stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");

    if ($stmt === false) {
        throw new Exception("Falha na preparação da query: " . $mysqli->error);
    }
    
    // Vincula o parâmetro 'id' à query. 'i' indica que é um número inteiro
    $stmt->bind_param("i", $userId);
    
    // Executa a query
    $stmt->execute();

    // Verifica se alguma linha foi afetada para saber se a exclusão foi bem-sucedida
    if ($stmt->affected_rows > 0) {
        logMessage("Usuário com ID {$userId} foi excluído com sucesso.", 'INFO');
        $_SESSION['message'] = 'Usuário excluído com sucesso.';
        $_SESSION['message_type'] = 'success';
    } else {
        logMessage("Falha ao excluir o usuário com ID {$userId} (ID não encontrado).", 'WARN');
        $_SESSION['message'] = 'Falha ao excluir o usuário. ID não encontrado.';
        $_SESSION['message_type'] = 'warning';
    }

    $stmt->close();
    
} catch (Exception $e) {
    logMessage("Erro ao excluir usuário: " . $e->getMessage(), 'ERROR');
    $_SESSION['message'] = 'Erro ao excluir usuário. Tente novamente mais tarde.';
    $_SESSION['message_type'] = 'danger';
}

// Redireciona o usuário de volta para a página de listagem
header("Location: index.php");
exit();
?>