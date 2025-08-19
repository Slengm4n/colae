<?php
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../../logs/logger.php';
checkAdmin();

if ($_SESSION['user_role'] !== 'admin') {
    logMessage("Tentativa de acesso não autorizado ao dashboard", 'SECURITY');
    header('Location: /public/403.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../config/database/db.php';

    $modality_name = trim($_POST['modality_name']);
    $modality_description = trim($_POST['modality_description']);

    try{
        $stmt = $mysqli->prepare("INSERT INTO modalities (modality_name, modality_description, created_at) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $modality_name, $modality_description, $created_at);
        $stmt->execute();

        logMessage("Modalidade '{$modality_name}' cadastrada por admin ID: {$_SESSION['user_id']}", 'INFO');

        $sucess_message = "Modalidade cadastrada com sucesso!";

    } catch (Exception $e) {
        logMessage("Erro ao cadastrar modalidade: " . $e->getMessage(), 'ERROR');
        $error_message = "Erro ao cadastrar modalidade. Tente novamente.";
    }
    header("Location: ./modalities.php");
    exit;
    
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Modalidades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <div class="container mt-5">
        <h2>Cadastrar Nova Modalidade Esportiva</h2>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="modalidade" class="form-label">Nome da Modalidade</label>
                <input type="text" class="form-control" id="modalidade" name="modality_name" required>
            </div>
            
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="modality_description" rows="3"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Cadastrar</button>
            <a href="home_admin.php" class="btn btn-secondary">Voltar</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>