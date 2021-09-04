<?php


namespace App\Session\User;


use App\Models\Entity\User;

class UserLogin
{
  protected static function init(): void {
    if (session_status() != PHP_SESSION_ACTIVE) {
      session_start();
    }
  }

  public static function login(User $user): bool
  {
    self::init();

    $roles = $user->Roles();
    $rolelevel = 0;
    $rolename = 'user';

    foreach ($roles as $role) {
      $rolelevel = $role->data()->level > $rolelevel ? $role->data()->level : $rolelevel;
      $rolename = $role->data()->level == $rolelevel ? $role->data()->name : $rolename;
    }

    $_SESSION['login']['user'] = [
      'id' => $user->id,
      'first_name' => $user->first_name,
      'last_name' => $user->last_name,
      'user_name' => $user->user_name,
      'email_address' => $user->email_address,
      'image' => $user->image ?? '',
      'role_name' => $rolename,
      'role_level' => $rolelevel
    ];

    return true;
  }

  public static function isLogged(): bool
  {
    self::init();

    return isset($_SESSION['login']['user']['id']);
  }

  public static function logout(): bool
  {
    self::init();

    unset($_SESSION['login']['user']);

    return true;
  }

  public static function roleLevel()
  {
    return $_SESSION['login']['user']['role_level'];
  }
}