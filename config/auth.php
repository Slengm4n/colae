<?php

//Função para verificar se a role consta como ADM, para páginas exclusivas
function checkAdmin(){
    session_start();
    if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== 'admin'){
        header("Location: ../public/403.php");
        exit;
    }
}
