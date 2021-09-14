<?php

namespace App\Controllers\api;

use App\Core\Model;
use App\Http\Dispatch;
use App\Http\Request;
use App\Models\Entity\Anime;
use App\Utils\Paginator;

class AnimeController extends ApiController
{
  public function index(Request $request)
  {

    $model = new Anime();

    $generetePaginator = $this->paginator($model->select(), $request);

    $animes = $generetePaginator['animes'];

    $paginator = $generetePaginator['paginator'];

    $itens = $this->genereteArrayAnime($animes);

    $this->response(200, $itens, 'application/json', $paginator);
  }

  public function search(Request $request, string $name)
  {
    $model = new Anime();

    $generetePaginator = $this->paginator($model->select()->where('name', 'like', $name), $request);

    $animes = $generetePaginator['animes'];

    $paginator = $generetePaginator['paginator'];

    $itens = $this->genereteArrayAnime($animes);

    $this->response(200, $itens, 'application/json', $paginator);
  }

  protected function paginator(Model $model, Request $request): array
  {
    $queryParams = $request->getQueryParams();

    $page = $queryParams['page'] ?? false;
    $limit = $queryParams['limit'] ?? 10;

    if ($page) {
      $paginator = new Paginator($model->count(), (int)$page, (int)$limit);
      $animes = $model->limit($paginator->limit())->offset($paginator->offset());
    } else {
      $animes = $model;
    }

    return ['animes' => $animes, 'paginator' => $paginator];
  }

  protected function genereteArrayAnime($animes) {

    foreach ($animes->fetch(true) as $objAnime) {
      $itens[] = [
        'id' => $objAnime->id,
        'name' => $objAnime->name,
        'sinopse' => $objAnime->sinopse,
        'classification' => $objAnime->classification,
        'image' => $objAnime->image,
        'backgroundimage'=> $objAnime->backgroundimage,
        'studio' => $objAnime->studio,
        'year' => $objAnime->year,
        'active' => $objAnime->active
      ];
    }

    return $itens;
  }
}