<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        /* Estilo para a página de login */
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
            padding: 20px 0;
        }

        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
        }

        input {
            width: 100%;
            padding: 0.5rem;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 0.7rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        .error {
            color: red;
            margin-bottom: 1rem;
            text-align: center;
        }

        .register-link {
            text-align: center;
            margin-top: 1rem;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1>Acessar Sistema</h1>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <!-- CORREÇÃO AQUI: Usando a constante BASE_URL para o action do formulário -->
        <form action="<?php echo BASE_URL; ?>/login/authenticate" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Entrar</button>
        </form>

        <div class="register-link">
            <p>Não tem uma conta? <a href="<?php echo BASE_URL; ?>/register">Crie uma aqui</a></p>
        </div>
        <!-- Dentro do seu .login-container -->
        <div style="text-align: right; font-size: 0.9em; margin-top: -0.5rem; margin-bottom: 1rem;">
            <a href="<?php echo BASE_URL; ?>/forgot-password">Esqueci minha senha</a>
        </div>
    </div>
</body>

</html>