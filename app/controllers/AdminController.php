

<?php

require_once __DIR__ . '/../core/AuthHelper.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Sport.php';

class AdminController
{

    public function dashboard()
    {
        AuthHelper::checkAdmin();
        try {
            $users = User::getAll();
            $sports = Sport::getAll();

            $data = [
                'users' => $users,
                'sports' => $sports,
            ];

            require __DIR__ . '/../views/admin/dashboard.php';
        } catch (Exception $e) {
            echo "Erro ao carregar o dashboard: " . $e->getMessage();
        }
    }

    public function showMap()
{
    AuthHelper::check(); // Ou verifique se é um admin
    
    // Busca todas as quadras com coordenadas
    $venuesWithCoords = Venue::getAllWithCoordinates();
    
    // Carrega a view do mapa e passa os dados para ela
    require BASE_PATH . '/app/views/admin/map.php';
}
}
