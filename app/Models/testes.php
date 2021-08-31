<?php

require __DIR__."/../../vendor/autoload.php";

use App\Models\Entity\Role;
use App\Models\Entity\User;
use App\Models\Entity\UserRoleRelation;

require __DIR__.'/../../bootstrap/class/Environment.php';

Environment::load(__DIR__.'/../..');

define("BASE_URL", getenv('BASE_URL'));

$model = new User();

$users = $model->find()->fetch();
print_r($users);

$users = $model->find()->limit(2)->fetch(true);
print_r($users);

$users = $model->find()->limit(2)->offset(1)->fetch(true);
print_r($users);

$users = $model->find()->limit(2)->offset(2)->order("first_name ASC")->fetch(true);
print_r($users);

//foreach ($users as $user) {
//  echo $user->fist_name;
//}

//$user = $model->find("first_name = :name", "name=Miguel")->fetch();
//echo $user->fist_name;

//$user = $model->find("fist_name = :name AND last_name = :last", "name=Miguel&last=Siqueira");
//echo $user->first_name.' '.$user->last_name;

//$user = $model->findById(1);
//echo $user->first_name;

//$params = http_build_query(["name" => "sla"]);

$user = new User();

$user->first_name = "Millene";
$user->last_name = "Siqueira";
$user->user_name = "millene";
$user->email_address = "millene@gmail.com";
$user->password = "123";

$userId = $user->save();

//print_r($userId);

//$model = new User();

//$user = $model->findById(1)->data();

//print_r($user);

//$role = new Role();

//$role->name = "ADM";
//$role->level = 10;

//$role->save();

$userrolerelation = new UserRoleRelation();

$userrolerelation->id_user = 1;
$userrolerelation->id_role = 1;

$userrolerelation->save();

