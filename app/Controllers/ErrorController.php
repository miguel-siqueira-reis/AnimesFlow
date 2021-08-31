<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Http\Response;

class ErrorController extends Controller
{
    public function index($errorCode)
    {
        $response = new Response($errorCode, 'error '.$errorCode);
        $response->sendResponse();
    }
}