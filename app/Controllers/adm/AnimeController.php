<?php

namespace App\Controllers\adm;

use App\Http\Response;

class AnimeController extends AdmController
{
  public function index(): Response
  {
    return $this->load('adm/anime');
  }
}