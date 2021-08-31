<?php

namespace App\Http;

class Router extends Dispatch
{

  public function __construct(string $base_url, $group='')
  {
    parent::__construct($base_url, $group);
  }

  public function get($route, $callback, string $name = null): void
  {
    $this->addRoute("GET", $route, $callback, $name);
  }

  public function post($route, $callback, string $name=null): void
  {
    $this->addRoute("POST", $route, $callback, $name);
  }

  public function put($route, $callback, string $name= null): void
  {
    $this->addRoute("PUT", $route, $callback, $name);
  }

  public function patch($route, $callback, string $name= null): void
  {
    $this->addRoute("PATCH", $route, $callback, $name);
  }

  public function delete($route, $callback, string $name= null): void
  {
    $this->addRoute("DELETE", $route, $callback, $name);
  }

  public function group($groupName, $callback)
  {
    $groupName = $this->group.$groupName;
    $this->groupRouter[] = new Router($this->baseUrl, $groupName);
    return $callback(end($this->groupRouter));
  }
}