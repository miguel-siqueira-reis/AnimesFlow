<?php

namespace App\Core;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Controller
{
  protected function load(string $view, $params = [])
  {
    $twig = new \Twig\Environment(
      new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../resources/view/')
    );

    echo $twig->render($view . '.twig', $params);
  }
}
