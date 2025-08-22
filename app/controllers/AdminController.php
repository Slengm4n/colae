

<?php 

require_once __DIR__ . '/../core/AuthHelper.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Sport.php';

class AdminController{
    
    public function dashboard(){
        try{
            $users = User::getAll();
            $sports = Sport::getAll();

            $data = [
                'users' => $users,
                'sports' => $sports,
            ];
            
            require __DIR__ . '/../views/admin/dashboard.php';
        }catch (Exception $e){
            echo "Erro ao carregar o dashboard: " . $e->getMessage();
        }
    }
}