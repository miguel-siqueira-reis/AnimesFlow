<?php

namespace App\Http\outraforma;

class RouterGroup extends Routers
{
  public function __construct(string $base_url, $group='')
  {
    parent::__construct($base_url, $group);
  }

}