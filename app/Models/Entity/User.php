<?php

namespace App\Models\Entity;

use App\Core\Model;

class User extends Model
{
  protected string $primary = 'id';

  protected string $table = 'users';

  protected array $required = ['first_name', 'last_name', 'user_name', 'email_address', 'password'];

  protected bool $timestamps = false;


  public function Roles()
  {
    $userRoleRelation = new UserRoleRelation();
    $userRoleRelation->roles();
  }

}
