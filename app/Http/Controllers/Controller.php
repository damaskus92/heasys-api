<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[
    OA\Info(version: '1.0', title: 'HeaSys API Documentation'),
    OA\Server(url: 'http://127.0.0.1:8000', description: 'Local'),
]
abstract class Controller
{
    //
}
