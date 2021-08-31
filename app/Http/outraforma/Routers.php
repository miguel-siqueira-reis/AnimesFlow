<?php

namespace App\Http\outraforma;

use App\Http\Request;

class Routers
{
  use RouterTrait;

  protected string $baseUrl;
  protected string $prefix = '';
  protected static array $routes = [];
  protected array $groupRouter;
  protected $route;
  protected string $group = '';
  protected Request $request;

  public function __construct(string $base_url, $group = '')
  {
    $this->baseUrl =(substr($base_url, "-1") == "/" ? substr($base_url, 0, -1) : $base_url);;
    $this->request = new Request();
    $this->group = $group ?? '';
    $this->setPrefix();
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
    $this->groupRouter[] = new RouterGroup($this->baseUrl, $groupName);
    return $callback(end($this->groupRouter));
  }
}