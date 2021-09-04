<?php

use App\Http\Router;

$router = new Router(BASE_URL);

$router->get('/', [\App\Controllers\pages\HomeController::class, 'index'], 'home');

$router->get('/login', [\App\Controllers\pages\LoginController::class, 'index'], 'login', ['require-user-logout']);
$router->post('/login', [\App\Controllers\pages\LoginController::class, 'login'],'login_do', ['require-user-logout']);

$router->get('/register', [\App\Controllers\pages\RegisterController::class, 'index'], 'register', ['require-user-logout']);
$router->post('/register', [\App\Controllers\pages\RegisterController::class, 'register'], 'register_do', ['require-user-logout']);

$router->get('/logout', [\App\Controllers\pages\LoginController::class, 'logout'], 'logout', ['require-user-login']);


$router->group('/adm', function($router) {
  $router->get('/', [\App\Controllers\adm\HomeAdmController::class, 'index'], 'adm.home', ['require-role-10']);

});




$router->get('/error/{errorCode}', [\App\Controllers\pages\ErrorController::class, 'index'], 'error');

$router->dispatch();

$err = $router->getError();

if ($err) {
    $router->redirect('error', ['errorCode' => $err]);
}
