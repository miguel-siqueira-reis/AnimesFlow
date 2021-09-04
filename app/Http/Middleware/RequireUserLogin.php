<?php

namespace App\Http\Middleware;

use App\Session\User\UserLogin;

class RequireUserLogin implements Middleware
{
  public function handle($request, $next)
  {
    if (!UserLogin::isLogged()) {
      $request->getRouter()->redirect('login');
    }

    return $next($request);
  }
}