<?php

$router->group('/api', function($router) {
  $router->group('/animes',  function($router) {
    $router->get('/', [\App\Controllers\api\AnimeController::class, 'index'], 'api.animes');
    $router->get('/search/{name}', [\App\Controllers\api\AnimeController::class, 'search'], 'api.anime_serach');
  });

  $router->group('/seasons', function ($router) {
    $router->get('/', [\App\Controllers\api\SeasonController::class, 'index'], 'api.seasons');
  });
  $router->group('/episodes', function ($router) {
    $router->get('/', [\App\Controllers\api\EpisodeController::class,'index'], 'api.episodios');
    $router->get('/search/{name}', [\App\Controllers\api\EpisodeController::class, 'search'], 'api.episodio_search');
  });
});


