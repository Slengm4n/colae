<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
    <style>
        /* Estilos consistentes com as outras telas */
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
            text-align: center;
        }

        h1 {
            margin-bottom: 1.5rem;
        }

        p {
            margin-bottom: 1.5rem;
            color: #666;
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
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .message {
            margin-top: 1rem;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Esqueceu sua senha?</h1>
        <p>Digite seu e-mail abaixo e enviaremos um link para você redefinir sua senha.</p>

        <?php if (isset($message)): ?>
            <p class="message <?php echo $status; ?>"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form action="<?php echo BASE_URL; ?>/forgot-password" method="POST">
            <input type="email" name="email" placeholder="Seu e-mail" required>
            <button type="submit">Enviar Link de Recuperação</button>
        </form>
    </div>
</body>

</html>