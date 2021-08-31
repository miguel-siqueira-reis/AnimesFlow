<?php


namespace App\Http\outraforma;

trait RouterTrait
{
  protected $data;

  protected function addRoute(string $method, string $route, $callback, string $name = null): void
  {

    if ($route === "/") {
      $this->addRoute($method, "", $callback, $name);
    }

    $route = $this->group.$route;

    preg_match_all("~\{\s* ([a-zA-Z_][a-zA-Z0-9_-]*) \}~x", $route, $keys, PREG_SET_ORDER);
    $routeDiff = array_values(array_diff(explode("/", $this->request->getUri()), explode("/", $route)));
    $offset = 0;
    $this->data = null;
    foreach ($keys as $key) {
      $this->data[$key[1]] = ($routeDiff[$offset++] ?? null);
    }

    $data = $this->data;

    $router = function() use ($method, $route, $callback, $data, $name) {
      return [
        'name' => $name,
        'route' => $route,
        'method' => $method,
        'handler' => $this->getHandler($callback),
        'action' => $this->getAction($callback),
        'data' => $data
      ];
    };

    $route = preg_replace('~{([^}]*)}~', "([^/]+)", $route);

    self::$routes[$method][$route] = $router();
  }

  public function getHandler($callback)
  {
    if (is_callable($callback)) {
      return $callback;
    }

    return $callback[0];
  }

  public function getAction($callback)
  {
    if (is_callable($callback)) {
      return false;
    }

    return $callback[1];
  }

  protected function getUri()
  {
    $uri = $this->request->getUri();

    $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

    return end($xUri);
  }

  protected function setPrefix(): void
  {
    $urlParse = parse_url($this->baseUrl);

    $this->prefix = $urlParse['path'] ?? '';

  }
}