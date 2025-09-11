<?php
AuthHelper::start(); // Garante que a sessão está iniciada 
// Verifica se há mensagens de erro ou sucesso na URL
$error = $_GET['error'] ?? null;
$status = $_GET['status'] ?? null;
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

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-warning {
            color: #856404;
            background-color: #fff3cd;
            border-color: #ffeeba;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert a {
            font-weight: bold;
            color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="panel-container">
        <nav>
            <div>
                <a href="<?php echo BASE_URL; ?>/dashboard">Meu Painel</a>
                <a href="<?php echo BASE_URL; ?>/quadras">Minhas Quadras</a>
            </div>
            <div>
                <a href="<?php echo BASE_URL; ?>/logout">Sair</a>
            </div>
        </nav>

        <h1>Bem-vindo(a), <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>

        <?php if (empty($_SESSION['user_cpf'])): ?>
            <div class="alert alert-warning">
                <strong>Cadastro Pendente:</strong> Para cadastrar e gerenciar suas quadras, por favor, valide seu CPF.
                <a href="<?php echo BASE_URL; ?>/dashboard/cpf">Adicionar CPF agora</a>.
            </div>
        <?php endif; ?>

        <?php if ($error === 'cpf_required'): ?>
            <div class="alert alert-warning">
                <strong>Ação necessária:</strong> Você precisa adicionar um CPF válido para poder cadastrar uma nova quadra.
                <a href="<?php echo BASE_URL; ?>/dashboard/cpf">Clique aqui para adicionar</a>.
            </div>
        <?php endif; ?>

        <?php if ($status === 'cpf_success'): ?>
            <div class="alert alert-success">
                <strong>Sucesso!</strong> Seu CPF foi validado e agora você pode cadastrar suas quadras.
            </div>
        <?php endif; ?>

        <p>Este é o seu painel de usuário. Use os links acima para navegar.</p>

    </div>
</body>

</html>