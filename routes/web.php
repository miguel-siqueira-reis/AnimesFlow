<?php

use App\Http\Router;

$router = new Router(BASE_URL);

$router->get('/', [\App\Controllers\HomeController::class, 'index'], 'home');

$router->get('/teste', function () {
  echo "to no teste";
});

$router->get('/error/{errorCode}', [\App\Controllers\ErrorController::class, 'index'], 'error');

$router->dispatch();

$err = $router->getError();

if ($err) {
    $router->redirect('error', ['errorCode' => $err]);
}
