<?php


namespace App\Controllers\pages;


use App\Http\Request;
use App\Models\Entity\User;

class RegisterController extends PagesController
{
  public function index(Request $request)
  {
    $status = $request->getQueryParams()['status'] ?? null;
    $message = $request->getQueryParams()['messageStatus'] ?? null;
    return $this->load('pages/register', [
      'status' => $status,
      'message' => $message
    ]);
  }

  public function register(Request $request)
  {
    $post = $request->getPostVars();
    $firstname = $post['firstname'] ?? '';
    $lastname = $post['lastname'] ?? '';
    $username = $post['username'] ?? '';
    $email = $post['email'] ?? '';
    $password = $post['password'] ?? '';

    $user = new User();

    if (User::has('user_name', $username)) {
      $request->getRouter()->redirect('register', ['messageStatus' => 'this username already exists.', 'status' => 'error']);
    }
    if (User::has('email_address', $email)) {
      $request->getRouter()->redirect('register', ['messageStatus' => 'this email already exists.', 'status' => 'error']);
    }

    $user->first_name = $firstname;
    $user->last_name = $lastname;
    $user->user_name = $username;
    $user->email_address = $email;
    $user->setPassword($password);

    $userId = $user->save();

    if ($user->error()) {
      $request->getRouter()->redirect('register', ['messageStatus' => 'error when registering user.', 'status' => 'error']);
    }

    $request->getRouter()->redirect('login', ['messageStatus' => 'User created successfully, please login below.', 'status' => 'success']);
  }
}