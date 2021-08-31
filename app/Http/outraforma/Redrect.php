<?php

namespace App\Http\outraforma;

trait Redrect
{
  public function redirect($route, $data=null): void
  {
    if ($name = $this->route($route, $data)) {
      header("Location: {$name}");
      exit;
    }

    if (filter_var($route, FILTER_VALIDATE_URL)) {
      header("Location: {$route}");
      exit;
    }

    $route = (substr($route, 0, 1) == '/' ? $route : "/{$route}");
    header("Location: {$this->baseUrl}{$route}");
    exit;
  }

  public function route(string $name, array $data = null): ?string
  {
    foreach (self::$routes as $http_verb) {
      foreach ($http_verb as $route_item) {
        if (!empty($route_item['name']) && $route_item['name'] == $name) {
          return $this->treat($route_item, $data);
        }
      }
    }
    return null;
  }

  public function treat($route_item, $data): ?string
  {
    $route = $route_item['route'];
    if (!empty($data)) {
      $args = [];
      $param = [];
      foreach($data as $key => $value) {
        if (!strstr($route, "{{$key}}")) {
          $param[$key] = $value;
        }
        $args["{{$key}}"] = $value;
      }
      $route = $this->process($route, $args, $param);
    }
    return "{$this->baseUrl}{$route}";
  }

  public function process($route, $args, $param): string
  {
    $param = (!empty($param) ? "?".http_build_query($param) : null);
    return str_replace(array_keys($args), array_values($args), $route)."${param}";
  }
}