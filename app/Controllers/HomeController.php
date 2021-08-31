<?php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{

    public function index()
    {
        $this->load('pages/home', [
          'title' => 'oi to passando a variavel do controller para o twig'
        ]);
    }
}