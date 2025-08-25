<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Dashboard do Administrador</title>
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.6;
            margin: 20px;
            background-color: #f4f4f4;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2 {
            color: #333;
        }

        nav {
            margin-bottom: 20px;
        }

        nav a {
            margin-right: 15px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #eee;
        }

        .logout {
            float: right;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <nav>
            <a href="http://localhost/colae/admin">Dashboard</a>
            <a href="http://localhost/colae/usuarios">Gerenciar Usuários</a>
            <a href="http://localhost/colae/esportes">Gerenciar Esportes</a>
            <a href="http://localhost/colae/logout" class="logout">Sair</a>
        </nav>

        <h1>Dashboard do Administrador</h1>

        <h2>Usuários Cadastrados</h2>
        <?php if (!empty($data['users'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Função</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['users'] as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                            <td><?php echo htmlspecialchars($user['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum usuário encontrado.</p>
        <?php endif; ?>

    </div>
</body>

</html>