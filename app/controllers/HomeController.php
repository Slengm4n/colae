<?php

class HomeController
{
    /**
     * Exibe a página inicial do site.
     */
    public function index()
    {
        // A única função deste método é carregar a view da página inicial.
        require_once BASE_PATH . '/app/views/home/index.php';
    }
}
