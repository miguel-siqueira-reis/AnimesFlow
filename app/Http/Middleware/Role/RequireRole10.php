<?php

namespace App\Http\Middleware\Role;

use App\Http\Middleware\Middleware;
use App\Http\Request;
use App\Session\User\UserLogin;
use Closure;

class RequireRole10 implements Middleware
{
  public function handle(Request $request,Closure $next)
  {
    if (UserLogin::roleLevel() < 10) {
      $request->getRouter()->redirect('home');
    }

    return $next($request);
  }
}