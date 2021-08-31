<?php

namespace App\Http\outraforma;

class Router extends Routers
{
  use Dispatch;

  use Redrect;

  protected $error;

  public const BAD_REQUEST = 400;
  public const NOT_FOUND = 404;
  public const METHOD_NOT_ALLOWED = 405;
  public const NOT_IMPLEMENTED = 501;


  public function __construct(string $base_url, $group='')
  {
    parent::__construct($base_url, $group);
  }

  public function getError()
  {
    return $this->error;
  }
}
