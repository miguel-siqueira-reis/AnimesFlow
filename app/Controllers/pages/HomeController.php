<?php

namespace App\Controllers\pages;

use App\Core\Controller;
use App\Http\Request;
use App\Session\User\UserLogin;

class HomeController extends PagesController
{

    public function index()
    {
        return $this->load('pages/home', [
          'title' => 'oi to passando a variavel do controller para o twig',
          'login' => UserLogin::isLogged()
        ]);
    }
}