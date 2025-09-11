<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <style>
        /* Estilos consistentes */
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        .container {
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

        input {
            width: 100%;
            padding: 0.5rem;
            box-sizing: border-box;
            margin-bottom: 1rem;
        }

        button {
            width: 100%;
            padding: 0.7rem;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .error {
            color: red;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Crie uma Nova Senha</h1>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form action="<?php echo BASE_URL; ?>/reset-password" method="POST">
            <!-- Campo oculto para enviar o token de volta para o servidor -->
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

            <label for="password">Nova Senha:</label>
            <input type="password" id="password" name="password" required>

            <label for="password_confirm">Confirme a Nova Senha:</label>
            <input type="password" id="password_confirm" name="password_confirm" required>

            <button type="submit">Salvar Nova Senha</button>
        </form>
    </div>
</body>

</html>