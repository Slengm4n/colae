<?php
    // Iniciar a sessão
session_start();

    // Verificar se o usuário está logado, e se estiver redireciona para a home (usuário comum)
if (isset($_SESSION["user_id"])) {
    header("Location: /public/home.php");
    exit;
}

function checkAdmin(){
    session_start();
    if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== 'admin'){
        header("Location: /acess_denied.php");
        exit;
    }
}

    // Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/config/database/db.php";

 
    $identifier = $_POST["identifier"];
    $password = $_POST["password"];
    
    // Preparar a consulta
    $stmt = $mysqli->prepare("SELECT id, name, email, password_hash FROM users WHERE email = ? OR name = ?");
    
    // Vincular os parâmetros
    $stmt->bind_param("ss", $identifier, $identifier);
    
    // Executar a consulta
    $stmt->execute();
    
    // Obter o resultado
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verificar a senha
        if (password_verify($password, $user["password_hash"])) {
            // Iniciar a sessão e definir o ID do usuário
            // Verifica 
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_role"] = $user["role"];      
            
            // Redirecionar para a página inicial
            header("Location: ./public/home.php");
            exit;
        } else {
            $invalid_login = true;
        }
    } else {
        $invalid_login = true;
    }
    
    // Fechar a consulta
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
                        <input type="date" id="signup_birthdate" name="birthdate" placeholder="RM" required>
                        <input type="password" id="signup_password" name="password" placeholder="Senha" required>
                        <input type="password" id="signup_password_confirmation" name="password_confirmation" placeholder="Confirme sua senha" required>
                        <input type="submit" class="btn" value="Cadastrar" />
                </form>
</body>
</html>