<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar Conta</title>
    <style>
        /* Usando o mesmo estilo da tela de login para manter a consistência */
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f4f4f4; padding: 20px 0; }
        .register-container { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h1 { text-align: center; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; }
        input { width: 100%; padding: 0.5rem; box-sizing: border-box; }
        button { width: 100%; padding: 0.7rem; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 1rem; }
        .error { color: red; margin-bottom: 1rem; }
        .login-link { text-align: center; margin-top: 1rem; }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Crie sua Conta</h1>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form action="/register/store" method="POST">
            <div class="form-group">
                <label for="name">Nome Completo:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
             <div class="form-group">
                <label for="birthdate">Data de Nascimento:</label>
                <input type="date" id="birthdate" name="birthdate" required>
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Registrar</button>
        </form>

        <div class="login-link">
            <p>Já tem uma conta? <a href="/login">Faça o login</a></p>
        </div>
    </div>
</body>
</html>
