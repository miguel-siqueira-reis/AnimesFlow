<?php

namespace App\Models\Entity;

use App\Core\Model;
use App\Models\Entity\UserRoleRelation;

class Role extends Model
{
  protected string $primary = "id";

  protected string $table = "Roles";

  protected array $required = ['name', 'level'];

  protected bool $timestamps = false;

  public function Users()
  {
    $userRoleRelation = new UserRoleRelation();
    $userRoleRelation->users();
  }
}