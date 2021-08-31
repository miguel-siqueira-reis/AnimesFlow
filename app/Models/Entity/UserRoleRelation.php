<?php

namespace App\Models\Entity;

use App\Core\Model;

class UserRoleRelation extends Model
{
  protected string $table = "UsersRolesRelation";

  protected string $primary = "id";

  protected array $required = ["id_user", "id_role"];

  protected bool $timestamps = false;

  public function users()
  {
    $users = new User();
    $users->where('id', $this->id_role);
  }

  public function roles()
  {
    $role = new Role();
    $role->where('id', $this->id_role);
  }

}