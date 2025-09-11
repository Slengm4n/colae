<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Bem-vindo ao Colaê</title>
    <style>
        /* Estilos para a página inicial */
        body {
            font-family: sans-serif;
            text-align: center;
            padding-top: 100px;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: auto;
        }

        h1 {
            font-size: 3rem;
        }

        p {
            font-size: 1.2rem;
            color: #666;
        }

        .actions {
            margin-top: 40px;
        }

        .actions a {
            display: inline-block;
            margin: 10px;
            padding: 15px 30px;
            font-size: 1.1rem;
            text-decoration: none;
            border-radius: 5px;
            color: white;
            transition: background-color 0.3s;
        }

        .login-btn {
            background-color: #007bff;
        }

        .login-btn:hover {
            background-color: #0056b3;
        }

        .register-btn {
            background-color: #28a745;
        }

        .register-btn:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Bem-vindo ao Colaê!</h1>
        <p>Sua plataforma para organizar e gerenciar eventos esportivos.</p>
        <div class="actions">
            <a href="<?php echo BASE_URL; ?>/login" class="login-btn">Entrar</a>
            <a href="<?php echo BASE_URL; ?>/register" class="register-btn">Criar Conta</a>
        </div>
    </div>
</body>

</html>