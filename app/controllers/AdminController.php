<?php

require_once __DIR__ . '/../core/AuthHelper.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Sport.php';
// Adicione o seu modelo Venue (ou Locais)
require_once __DIR__ . '/../models/Venue.php';

class AdminController
{


    public function dashboard()
    {
        AuthHelper::checkAdmin();
        try {
            // Supondo que você pega o nome do usuário logado da sessão
            // session_start(); // Garanta que a sessão foi iniciada
            $userName = $_SESSION['user_name'] ?? 'Admin';

            // Busque os totais usando a contagem dos arrays
            $totalUsers = count(User::getAll());
            $totalSports = count(Sport::getAll());
            $totalLocations = count(Venue::getAll()); // Usando seu modelo Venue

            // Pegue apenas os 5 usuários mais recentes para a tabela
            $allUsers = User::getAll();
            $recentUsers = array_slice($allUsers, 0, 5);

            // Monte o array $data com as chaves que a sua view no Canvas espera
            $data = [
                'userName' => $userName,
                'totalUsers' => $totalUsers,
                'totalSports' => $totalSports,
                'totalLocations' => $totalLocations,
                'recentUsers' => $recentUsers
            ];

            // Carregue a sua view do dashboard
            // Certifique-se de que o caminho está correto
            require __DIR__ . '/../views/admin/dashboard.php';
        } catch (Exception $e) {
            echo "Erro ao carregar o dashboard: " . $e->getMessage();
        }
    }


    public function showMap()
    {
        AuthHelper::checkAdmin(); // Garante que é um admin

        try {
            $userName = $_SESSION['user_name'] ?? 'Admin';

            // Busca todas as quadras com coordenadas do seu modelo
            $venuesWithCoords = Venue::getAllWithCoordinates();

            // Prepara os dados para a view
            $data = [
                'userName' => $userName
            ];

            // Carrega a view do mapa
            // A variável $venuesWithCoords estará disponível na view por causa do escopo
            require __DIR__ . '/../views/admin/map.php';
        } catch (Exception $e) {
            echo "Erro ao carregar o mapa: " . $e->getMessage();
        }
    }
}
