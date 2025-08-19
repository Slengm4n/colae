<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../logs/logger.php';
checkAdmin();

// Verifica se é admin
if ($_SESSION['user_role'] !== 'admin') {
    logMessage("Tentativa de acesso não autorizado ao dashboard", 'SECURITY');
    header('Location: /public/403.php');
    exit;
}

require_once __DIR__ . '/../config/database/db.php';
function getTotalUsers() {
    global $mysqli;
    $result = $mysqli->query("SELECT COUNT(*) as total FROM users");
    return $result->fetch_assoc()['total'];
}

function getTotalModalities() {
    global $mysqli;
    $result = $mysqli->query("SELECT COUNT(*) as total FROM sports");
    return $result->fetch_assoc()['total'];

}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .card:hover {
            transform: scale(1.03);
            transition: transform 0.3s;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="home_admin.php">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="./users/index.php">
                                <i class="bi bi-people me-2"></i>Gerenciar Usuários
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="./sports/index.php">
                                <i class="bi bi-trophy me-2"></i>Modalidades Esportivas 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="reports.php">
                                <i class="bi bi-graph-up me-2"></i>Relatórios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../services/logout.php">
                                <i class="bi bi-graph-up me-2"></i>Sair
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <h2 class="h3 mb-4">Dashboard Administrativo</h2>
                
                <!-- Cards Resumo -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white h-100" onclick="window.location='users.php'">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-people"></i> Usuários</h5>
                                <p class="card-text">Total: <?= getTotalUsers() ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white h-100" onclick="window.location='./sports/index.php'">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-trophy"></i> Modalidades Esportivas</h5>
                                <p class="card-text">Total: <?= getTotalModalities() ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-info text-white h-100" onclick="window.location='reports.php'">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-graph-up"></i> Relatórios</h5>
                                <p class="card-text">7 novos este mês</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seção de Atividades Recentes -->
                        </ul>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Exemplo de gráfico (usando Chart.js)
        document.addEventListener('DOMContentLoaded', function() {
            // Aqui você pode inicializar gráficos
            console.log('Dashboard carregado');
        });
    </script>
</body>
</html>