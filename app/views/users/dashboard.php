<?php AuthHelper::start(); // Garante que a sessão está iniciada 
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Meu Painel</title>
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.6;
            margin: 20px;
            background-color: #f4f4f4;
        }

        .panel-container {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        nav {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            margin-right: 15px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="panel-container">
        <nav>
            <div>
                <a href="<?php echo BASE_URL; ?>/dashboard">Meu Painel</a>
                <!-- Adicione outros links aqui, como "Minhas Reservas", etc. -->
            </div>
            <div>
                <a href="<?php echo BASE_URL; ?>/logout">Sair</a>
            </div>
        </nav>

        <h1>Bem-vindo(a), <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
        <p>Este é o seu painel de usuário. Em breve, você poderá ver suas reservas e outras informações aqui.</p>

    </div>
</body>

</html>