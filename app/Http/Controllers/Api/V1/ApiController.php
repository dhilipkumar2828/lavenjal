<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    public function allUsers(Request $request)
    {
        $users = User::all();
        return response()->json([
            'status'      => 'success',
            'status_code' => Response::HTTP_OK,
            'data'        => ['users' => $users],
            'message'     => 'All users pulled out successfully',
        ]);
    }
}