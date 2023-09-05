<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    public function login(Request $request) {
        try {
            // TODO: Validate Request
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
        
            // TODO: Find User By Email
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized']
                    , 401);
            }
            // TODO: Generate Token
        
            // TODO: Return Response

        }catch (Exception $e) {

        }

    }
}
