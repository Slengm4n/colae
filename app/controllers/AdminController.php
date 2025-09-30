<?php

require_once __DIR__ . '/../core/AuthHelper.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Sport.php';
require_once __DIR__ . '/../models/Venue.php';

class AdminController
{

    //Função index do dashboard
    public function dashboard()
    {
        // Usa o AuthHelper para que só usuários com role admin possa logar e acessar a página
        AuthHelper::checkAdmin();
        try {
            // Garante que a sessão foi iniciada
            $userName = $_SESSION['user_name'] ?? 'Admin';

            // Busque os totais usando a contagem dos arrays do métodos de cada Model
            $totalUsers = count(User::getAll());
            $totalSports = count(Sport::getAll());
            $totalLocations = count(Venue::getAll());

            // Pegando apenas os 5 usuários mais recentes para a tabela
            $allUsers = User::getAll();
            $recentUsers = array_slice($allUsers, 0, 5);


            // Monte o array $data com as chaves que a view no Canvas espera
            $data = [
                'userName' => $userName,
                'totalUsers' => $totalUsers,
                'totalSports' => $totalSports,
                'totalLocations' => $totalLocations,
                'recentUsers' => $recentUsers
            ];


            //Renderiza a view de dashboard de Admin
            require __DIR__ . '/../views/admin/dashboard.php';
        } catch (Exception $e) {
            echo "Erro ao carregar o dashboard: " . $e->getMessage();
        }
    }


    //Função para o mapa de quadras
    public function showMap()
    {
        // Usa o AuthHelper para que só usuários com role admin possa acessar a página
        AuthHelper::checkAdmin();

        try {
            // Garante que o usuário esteja logado
            $userName = $_SESSION['user_name'] ?? 'Admin';

            // Busca todas as quadras com coordenadas do Model Venue
            $venuesWithCoords = Venue::getAllWithCoordinates();

            // Prepara os dados para a view
            $data = [
                'userName' => $userName
            ];

            // Renderiza a view do mapa
            require __DIR__ . '/../views/admin/map.php';
        } catch (Exception $e) {
            echo "Erro ao carregar o mapa: " . $e->getMessage();
        }
    }
}
