<?php

use App\Http\Middleware\Queue;


Queue::setMap([
  'maintenance' => \App\Http\Middleware\Maintenance::class,
  'require-user-logout' => \App\Http\Middleware\RequireUserLogout::class,
  'require-user-login' => \App\Http\Middleware\RequireUserLogin::class,
  'require-role-10' => \App\Http\Middleware\Role\RequireRole10::class
]);

Queue::setDefault([
  'maintenance'
]);