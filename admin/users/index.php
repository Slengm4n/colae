<?php

require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../../logs/logger.php';
require_once __DIR__ . '/../../config/database/db.php';
checkAdmin();

// Verifica se é admin
if ($_SESSION['user_role'] !== 'admin') {
    logMessage("Tentativa de acesso não autorizado ao dashboard", 'SECURITY');
    header('Location: /public/403.php');
    exit;
}

$users = [];

try {
 
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE role = ?");

    if ($stmt === false) {
        throw new Exception("Falha na preparação da query: " . $mysqli->error);
    }

    $role = 'user';
    $stmt->bind_param("s", $role);
    
    $stmt->execute();
    
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    
    // Registrar no log
    logMessage("Acessou a lista de usuários, acessada por admin ID: {$_SESSION['user_id']}", 'INFO');
    
} catch (Exception $e) {
    logMessage("Erro ao buscar usuários: " . $e->getMessage(), 'ERROR');
    die("Erro ao carregar usuários. Tente novamente mais tarde.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .action-icon {
            width: 25px;
            height: 25px;
            transition: transform 0.2s;
        }
        .action-icon:hover {
            transform: scale(1.2);
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">Gerenciamento de Usuários</h2>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Criado em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['status']) ?></td>
                            <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                            <td>
                                <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="delete.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" title="Excluir" 
                                   onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <a href="create_user.php" class="btn btn-primary mt-3">
            <i class="bi bi-plus-circle"></i> Adicionar Novo Usuário
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"></script>
</body>
</html>