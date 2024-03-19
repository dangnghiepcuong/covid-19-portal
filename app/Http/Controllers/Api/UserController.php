<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class UserController extends BaseApiController
{
    public function currentUser(Request $request)
    {
        return response()->json([
            'data' => $request->user(),
        ], 200);
    }
}
