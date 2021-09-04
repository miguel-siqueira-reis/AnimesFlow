<?php

namespace App\Core;

use App\Http\Response;
use App\Utils\ExtensionTwig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Controller
{
  protected string $path = '/../../resources/view/';


  protected function load(string $view, $params = [])
  {
    $twig = new \Twig\Environment(
      new \Twig\Loader\FilesystemLoader(__DIR__.$this->path)
    );

    $twig->addExtension(new ExtensionTwig());

    return new Response(200, $twig->render($view . '.twig', $params));
  }


}
