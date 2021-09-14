<?php

use App\Http\Router;

$router = new Router(BASE_URL);

require ROOT."/routes/web.php";

require ROOT."/routes/api.php";

$router->dispatch();

$err = $router->getError();

if ($err) {
  $router->redirect('error', ['errorCode' => $err]);
}
