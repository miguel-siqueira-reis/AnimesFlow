<?php

require __DIR__."/../vendor/autoload.php";

session_start();

require __DIR__.'/class/Environment.php';

Environment::load(__DIR__.'/..');

define("BASE_URL", getenv('BASE_URL'));

define("ROOT", __DIR__.'/..');

require ROOT."/config/minify.php";

require ROOT."/routes/web.php";
