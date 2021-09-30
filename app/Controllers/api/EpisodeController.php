<?php

namespace App\Controllers\api;

use App\Http\Request;
use App\Models\Entity\Episode;

class EpisodeController extends ApiController
{
  public function index(Request $request)
  {
    $postVars = $request->getQueryParams();

    $tempId = $postVars['id_temporada'];

    $model = new Episode();

    if ($tempId) {
      $model = $model->select()->where('id_season', $tempId);
    }else {
      $model = $model->select();
    }

    $generetePaginator = $this->paginator($model, $request);

    $episodes = $generetePaginator['data'];

    $paginator = $generetePaginator['paginator'];

    $itens = $this->genereteArrayEpisode($episodes);

    $this->response(200, $itens, 'application/json', $paginator);
  }

  public function search(Request $request, string $name)
  {
    $postVars = $request->getQueryParams();

    $tempId = $postVars['id_temporada'];

    $model = new Episode();

    if ($tempId) {
      $model = $model->select()->where('name', 'like', $name)->where('id_season', $tempId);
    }else {
      $model = $model->select()->where('name', 'like', $name);
    }

    $generetePaginator = $this->paginator($model, $request);

    $episodes = $generetePaginator['data'];

    $paginator = $generetePaginator['paginator'];

    $itens = $this->genereteArrayEpisode($episodes);

    $this->response(200, $itens, 'application/json', $paginator);
  }

  private function genereteArrayEpisode($episodes): ?array
  {
    foreach ($episodes->fetch(true) as $episode) {
      $itens[] = [
        'id' => $episode->id,
        'name' => $episode->name,
        'number' => $episode->number,
        'image' => $episode->image,
        'watch' => $episode->watch,
        'id_season' => $episode->id_anime
      ];
    }
    return $itens ?? null;
  }
}