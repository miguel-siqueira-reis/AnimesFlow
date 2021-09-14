<?php

require __DIR__."/../../vendor/autoload.php";

use App\Core\Environment;
use App\Models\Entity\User;
use App\Utils\Paginator;

Environment::load(__DIR__.'/../..');

define("BASE_URL", getenv('BASE_URL'));

$model = new User();

$amount = $model->select()->count();

$paginator = new Paginator($amount, 1, 10);

$users = $model->select()->limit($paginator->limit())->offset($paginator->offset())->fetch(true);

foreach ($users as $user) {
  print_r($user->data());
}