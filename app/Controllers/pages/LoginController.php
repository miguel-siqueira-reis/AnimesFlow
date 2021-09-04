<?php


namespace App\Controllers\pages;


use App\Http\Request;
use App\Http\Router;
use App\Models\Entity\User;
use App\Session\User\UserLogin;

class LoginController extends pagesController
{

  public function index(Request $request)
  {
    $status = $request->getQueryParams()['status'] ?? null;
    $messageStatus = $request->getQueryParams()['messageStatus'] ?? null;
    return $this->load('pages/login', [
      'status' => $status,
      'message' => $messageStatus
    ]);
  }

  public function login(Request $request)
  {
    $post = $request->getPostVars();
    $username = $post['username'] ?? '';
    $password = $post['password'] ?? '';

    $model =  new User();
    $user = $model->findByUserName($username);

    if (!User::has('user_name', $username) || !password_verify($password, $user->password)) {
      $request->getRouter()->redirect('login', ['messageStatus' => 'Invalid password or email.', 'status' => 'error']);
    }

    UserLogin::login($user);

    $request->getRouter()->redirect('home');

  }

  public function logout($request)
  {
    UserLogin::logout();

    return $request->getRouter()->redirect('login');
  }
}