<?php

namespace App\Core;

use App\Http\Response;
use App\Utils\ExtensionTwig;
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

    $twig->addExtension(new ExtensionTwig());

    return new Response(200, $twig->render($view . '.twig', $params));
  }


}
