<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Session\User\UserLogin;
use Closure;

class RequireUserLogout implements Middleware
{
  public function handle(Request $request,Closure $next)
  {
    if (UserLogin::isLogged()) {
      $request->getRouter()->redirect('home');
    }

    return $next($request);
  }
}