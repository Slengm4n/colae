<?php
session_start();

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/config/database/db.php";

    $identifier = trim($_POST["identifier"]);
    $password = $_POST["password"];
    
    // Consulta para buscar usuário por email ou nome
    $stmt = $mysqli->prepare("SELECT id, name, email, password_hash, role FROM users WHERE email = ? OR name = ?");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verificar a senha
        if (password_verify($password, $user["password_hash"])) {
            // Configurar sessão
            //Segurança extra
            session_regenerate_id(true);
            $_SESSION["user_id"] = $user["id"];;
            $_SESSION["user_role"] = $user["role"];
            
            //Fechar o statement antes de redirecionar
            $stmt->close();

            // Redirecionar conforme o tipo de usuário
            if ($user["role"] === "admin") {
                header("Location: admin/home_admin.php");
            } else {
                header("Location: public/home.php");
            }
            exit;
        }
    }
    
    // Se chegou aqui, o login falhou
    $invalid_login= true;
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cadastro & Login</title>
</head>
<body>
                    <!--Caso o login esteja inválido-->
                    <?php if (isset($invalid_login)): ?>
                        <em>Login inválido</em><br>
                    <?php endif; ?>

                    <form action="" method="post">
                    <!--Método identifier utilizado para que o usuário possa fazer login tanto com o email quanto com o username cadastrado-->
                        <input type="text" id="login_identifier" name="identifier" placeholder="Login" value="<?= htmlspecialchars($_POST["identifier"] ?? "") ?>" required>

                        <input type="password" id="login_password" name="password" placeholder="Senha" required>

                        <input type="submit" value="Login" class="btn solid" />
                    </form>

                <!-- Formulário de Cadastro -->
                <form action="services/signup.php" method="post" class="sign-up-form">
                        <input type="text" id="signup_name" name="name" placeholder="Nome de usuário" required>
                        <input type="email" id="signup_email" name="email" placeholder="Email" required>
                        <input type="date" id="signup_birthdate" name="birthdate" placeholder="Aniversario" required>
                        <input type="password" id="signup_password" name="password" placeholder="Senha" required>
                        <input type="password" id="signup_password_confirmation" name="password_confirmation" placeholder="Confirme sua senha" required>
                        <input type="submit" class="btn" value="Cadastrar" />
                </form>
</body>
</html>