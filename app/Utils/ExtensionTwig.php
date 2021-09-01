<?php

namespace App\Utils;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class ExtensionTwig extends AbstractExtension implements GlobalsInterface
{

  public function getGlobals(): array
  {
    return [
    ];
  }
}