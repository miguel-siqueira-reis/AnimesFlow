<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Http\Response;
use Closure;

class Maintenance
{
  public function handle(Request $request, Closure $next): Response
  {
    if(getenv('MAINTENANCE') == 'true') {
      print_r('Desculpe mas essa pagina esta em manutenção. tente novamente mais tarde.');
      exit;
    }
    return $next($request);
  }
}