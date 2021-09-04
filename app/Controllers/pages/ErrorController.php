<?php

namespace App\Controllers\pages;

use App\Core\Controller;
use App\Http\Response;

class ErrorController extends PagesController
{
    public function index($errorCode)
    {
        $response = new Response($errorCode, 'error '.$errorCode);
        $response->sendResponse();
    }
}