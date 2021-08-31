<?php

namespace App\Http\outraforma;

trait Dispatch
{

  public function dispatch(): bool
  {

    if (empty(self::$routes)) {
      $this->error = self::NOT_IMPLEMENTED;
      return false;
    }

    $this->route = null;
    foreach (self::$routes[$this->request->getHttpMethod()] as $key => $route) {
      if (preg_match("~^" . $key . "$~", $this->getUri(), $found)) {
        $this->route = $route;
      }
    }
    return $this->execute();
  }


  private function execute(): bool
  {

    if ($this->route) {
      if (is_callable($this->route['handler'])) {
        call_user_func_array($this->route['handler'], ($this->route['data']? $this->route['data']: []));
        return true;
      }
      $controller = $this->route['handler'];
      $method = $this->route['action'];
      if (class_exists($controller)) {
        $newController = new $controller();
        if (method_exists($controller, $method)) {
          call_user_func_array(array($newController, $method), ($this->route['data']? $this->route['data']: []));
          return true;
        }
        $this->error = self::METHOD_NOT_ALLOWED;
        return false;
      }
      $this->error = self::BAD_REQUEST;
      return false;
    }
    $this->error = self::NOT_FOUND;
    return false;
  }
}