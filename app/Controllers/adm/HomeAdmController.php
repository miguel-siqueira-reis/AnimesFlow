<?php


namespace App\Controllers\adm;


use App\Http\Request;

class homeAdmController extends AdmController
{
  public function index(Request $request)
  {
    return $this->load('adm/home');
  }
}