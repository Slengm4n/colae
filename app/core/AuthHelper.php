<?php 

class AuthHelper{

    public static function start(){
        if (session_status() == PHP_SESSION_NONE){
            session_start();
        }   
     }

     public static function check(){
        self::start();
        if (!isset($_SESSION['user_id'])){
            header('Location: /login');
            exit;
        }
     }

     public static function checkAdmin(){
        self::check();
        if($_SESSION['user_role'] !== 'admin'){
            http_response_code(403);
            echo "<h1>Acesso Negado</h1><p>Você não tem permissão para acessar essa página!</p>";
            exit;
        }
     }
}