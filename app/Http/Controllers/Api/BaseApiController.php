<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

abstract class BaseApiController extends Controller
{
    protected $guard = 'api';
}
