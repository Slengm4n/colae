<?php
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../../logs/logger.php';
require_once __DIR__ . '/../../config/database/db.php';
checkAdmin();

// Verifica se o formulário foi enviado (método POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitiza e obtém os dados do formulário
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    // Hash da senha por segurança
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Define a role padrão para 'user'
    $role = 'user';
    
    try {
        // Prepara a query de inserção
        // O ponto de interrogação '?' é o placeholder para os parâmetros
        $stmt = $mysqli->prepare("INSERT INTO users (name, email, password, role, is_active) VALUES (?, ?, ?, ?, ?)");
        
        if ($stmt === false) {
            throw new Exception("Falha na preparação da query: " . $mysqli->error);
        }
        
        // Vincula os parâmetros à query
        // 'ssssi' -> string, string, string, string, integer
        $stmt->bind_param("ssssi", $name, $email, $hashedPassword, $role, $is_active);
        
        // Executa a query
        $stmt->execute();

        // Verifica se a inserção foi bem-sucedida
        if ($stmt->affected_rows > 0) {
            logMessage("Novo usuário criado com sucesso: {$email}", 'INFO');
            $_SESSION['message'] = 'Usuário criado com sucesso!';
            $_SESSION['message_type'] = 'success';
        } else {
            logMessage("Falha ao criar o usuário: {$email}", 'WARN');
            $_SESSION['message'] = 'Falha ao criar o usuário.';
            $_SESSION['message_type'] = 'danger';
        }
        
        $stmt->close();
        
    } catch (Exception $e) {
        // Erro no banco de dados, como e-mail duplicado
        logMessage("Erro ao criar usuário: " . $e->getMessage(), 'ERROR');
        $_SESSION['message'] = 'Erro ao criar usuário. Tente novamente mais tarde.';
        $_SESSION['message_type'] = 'danger';
    }

    // Redireciona o usuário de volta para a página de listagem
    header("Location: list_users.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Novo Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Adicionar Novo Usuário</h2>
        
        <form action="create_user.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                <label class="form-check-label" for="is_active">Usuário Ativo?</label>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Salvar Usuário
            </button>
            <a href="list_users.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar para a Lista
            </a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</body>
</html>