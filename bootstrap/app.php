<?php

use App\Http\Middleware\Queue;

require __DIR__."/../vendor/autoload.php";

session_start();

require __DIR__.'/class/Environment.php';

Environment::load(__DIR__.'/..');

define("BASE_URL", getenv('BASE_URL'));

define("ROOT", __DIR__.'/..');

Queue::setMap([
  'maintenance' => \App\Http\Middleware\Maintenance::class,
  'require-user-logout' => \App\Http\Middleware\RequireUserLogout::class,
  'require-user-login' => \App\Http\Middleware\RequireUserLogin::class,
  'require-role-10' => \App\Http\Middleware\Role\RequireRole10::class
]);

Queue::setDefault([
  'maintenance'
]);

require ROOT."/config/minify.php";

require ROOT."/config/function-default.php";

require ROOT."/routes/web.php";
