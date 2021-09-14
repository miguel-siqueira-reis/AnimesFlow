<?php

$router->group('/api', function($router) {
  $router->group('/animes',  function($router) {
    $router->get('/', [\App\Controllers\api\AnimeController::class, 'index'], 'api.anime');
    $router->get('/search/{name}', [\App\Controllers\api\AnimeController::class, 'search'], 'api.anime_serach');
  });
});


