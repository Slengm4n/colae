<?php

namespace App\Controllers;

// Importa as classes necessárias que serão utilizadas no controller.
use App\Core\AuthHelper;
use App\Core\View;
use App\Core\ViewHelper;
use App\Models\User;
use App\Models\Sport;
use App\Models\Venue;
use Exception;

class AdminController
{
    /*** Exibe o dashboard principal do administrador com estatísticas e dados recentes.*/
    public function dashboard()
    {
        // Garante que apenas administradores possam acessar esta página.
        AuthHelper::checkAdmin();

        try {
            // Prepara os dados que serão enviados para a view.
            $data = [
                'userName' => $_SESSION['user_name'] ?? 'Admin',
                // Busca os totais diretamente do banco para mais eficiência.
                'totalUsers' => User::countAll(),
                'totalSports' => Sport::countAll(),
                'totalLocations' => Venue::countAll(),
                // Busca apenas os 5 usuários mais recentes.
                'recentUsers' => User::getRecent(5)
            ];

            // Renderiza a view do dashboard, passando os dados para ela.
            ViewHelper::render('admin/dashboard', $data);
        } catch (Exception $e) {
            // Em caso de erro, exibe uma mensagem. O ideal em produção seria logar o erro.
            // Por exemplo: error_log($e->getMessage());
            echo "Erro ao carregar o dashboard: " . $e->getMessage();
        }
    }

    /*** Exibe o mapa com a localização de todas as quadras.*/
    public function showMap()
    {
        // Garante que apenas administradores possam acessar esta página.
        AuthHelper::checkAdmin();

        try {
            // Busca todas as quadras que possuem coordenadas geográficas.
            $venuesWithCoords = Venue::getAllWithCoordinates();

            // Prepara os dados para a view.
            $data = [
                'userName' => $_SESSION['user_name'] ?? 'Admin',
                // Converte os dados das quadras para JSON para ser usado pelo JavaScript no mapa.
                'venuesJson' => json_encode($venuesWithCoords)
            ];

            // Renderiza a view do mapa, passando os dados para ela.
            ViewHelper::render('admin/map', $data);
        } catch (Exception $e) {
            // Em caso de erro, exibe uma mensagem.
            echo "Erro ao carregar o mapa: " . $e->getMessage();
        }
    }
}
