<?php

namespace App\Controllers\api;


use App\Core\Model;
use App\Http\Request;
use App\Http\Response;
use App\Utils\Paginator;

class ApiController
{
  protected function paginator(Model $model, Request $request): array
  {
    $queryParams = $request->getQueryParams();

    $page = $queryParams['page'] ?? false;
    $limit = $queryParams['limit'] ?? 10;

    if ($page) {
      $paginator = new Paginator($model->count(), (int)$page, (int)$limit);
      $data = $model->limit($paginator->limit())->offset($paginator->offset());
    } else {
      $data = $model;
    }

    return ['data' => $data, 'paginator' => $paginator];
  }

  protected function response(int $code, $content, string $contentType = 'application/json', $paginator = false)
  {
    if (empty($content)) {
      $content = [
        'error' => 'não encontramos nenhum resultado na consulta',
        'codeError' => 500,
      ];
      $code = 200;

      $this->send($code, $content, $contentType);
    }

    if (empty($content[1])) {
      $content = $content[0];
    }


    $json = [
      'data' => $content,
      'paginator' => $paginator? [
        'current_page' => $paginator->currentPage(),
        'limit' => $paginator->limit(),
        'offset' => $paginator->offset(),
        'total' => $paginator->results(),
        'pages' => $paginator->pages()
      ]: false,
    ];

    $this->send($code, $json, $contentType);

  }

  protected function send($code, $json, $contentType)
  {
    return new Response($code, $json, $contentType);
  }
}