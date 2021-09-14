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

  protected int $httpCode = 200;

  protected string $contentType = 'text/html';

  protected function load(string $view, $params = []): Response
  {
    $twig = new \Twig\Environment(
      new \Twig\Loader\FilesystemLoader(__DIR__.$this->path)
    );

    $twig->addExtension(new ExtensionTwig());

    return new Response($this->httpCode, $twig->render($view . '.twig', $params), $this->contentType);
  }



}
