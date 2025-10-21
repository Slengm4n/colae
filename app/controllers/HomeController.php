<?php

namespace App\Controllers;

use App\Core\ViewHelper;

/**
 * Class HomeController* Controla a exibição da página inicial.*/
class HomeController
{
    /*** Exibe a página inicial do site.*/
    public function index()
    {
        // Prepara quaisquer dados que a página inicial possa precisar (mesmo que vazios por agora)
        $data = [];

        // Renderiza a view da página inicial usando a classe View.
        ViewHelper::render('home/index', $data);
    }
}
