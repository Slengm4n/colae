<?php

require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../../logs/logger.php';
checkAdmin();

$msg = '';
// Verifica se é admin
if ($_SESSION['user_role'] !== 'admin') {
    logMessage("Tentativa de acesso não autorizado ao cadastro de esportes", 'SECURITY');
    header('Location: /public/403.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/../../config/database/db.php";

    $sql = "INSERT INTO sports (sport) VALUES (?)";
    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        $msg = "Erro ao preparar a consulta: " . $mysqli->error;
    } else {
        $stmt->bind_param("s", $_POST["sport"]);
        if ($stmt->execute()) {
            $msg = "Esporte cadastrado com sucesso!";
        } else {
            $msg = "Erro ao cadastrar esporte: " . $mysqli->error;
        }

        $stmt->close();
    }
}

$sports = [];
$result = $mysqli->query("SELECT * FROM sports");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $sports[] = $row;
    }
} else {
    logMessage("Erro ao buscar esportes: " . $mysqli->error, 'ERROR');
    $msg = "Erro ao buscar esportes.";
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Esporte</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        form {
            max-width: 300px;
        }

        input[type=text],
        button {
            width: 100%;
            padding: 8px;
            margin-top: 8px;
        }

        .msg {
            margin-top: 10px;
            color: green;
        }

        .erro {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Cadastrar Esporte</h1>
    <form method="POST">
        <label for="name">Nome do Esporte:</label>
        <input type="text" name="sport" id="SportName" required>
        <button type="submit">Cadastrar</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Esporte</th>
                <th>Data de Cadastro</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sports as $sport): ?>
                <tr>
                    <td><?= htmlspecialchars($sport['id']) ?></td>
                    <td><?= htmlspecialchars($sport['sport']) ?></td>
                    <td><?= htmlspecialchars($sport['created_at']) ?></td>
                    <td class="actions">
                        <a href="editar.php?id=<?= $sport['id'] ?>" class="btn btn-edit">Editar</a>
                        <a href="excluir.php?id=<?= $sport['id'] ?>" class="btn btn-delete"
                            onclick="return confirm('Tem certeza que deseja excluir este esporte?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($msg): ?>
        <p class="<?= strpos($msg, 'Erro') !== false ? 'erro' : 'msg' ?>">
            <?= htmlspecialchars($msg) ?>
        </p>
    <?php endif; ?>
</body>

</html>