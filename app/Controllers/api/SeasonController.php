<?php

namespace App\Controllers\api;

use App\Http\Request;
use App\Models\Entity\Season;

class SeasonController extends ApiController
{
  public function index(Request $request)
  {
    $postVars = $request->getQueryParams();

    $animeId = $postVars['id_anime'];

    $model = new Season();

    if ($animeId) {
      $model = $model->select()->where('id_anime', $animeId);
    }else {
      $model = $model->select();
    }

    $generetePaginator = $this->paginator($model, $request);

    $seasons = $generetePaginator['data'];

    $paginator = $generetePaginator['paginator'];

    $itens = $this->genereteArraySeason($seasons);

    $this->response(200, $itens, 'application/json', $paginator);
  }

  private function genereteArraySeason($seasons)
  {

    foreach ($seasons->fetch(true) as $season) {
      $itens[] = [
        'id' => $season->id,
        'number' => $season->number,
        'id_anime' => $season->id_anime
      ];
    }

    return $itens;
  }
}