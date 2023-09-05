<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
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

            // TODO: Generate Token
        
            // TODO: Return Response

        }catch (Exception $e) {

        }

    }
}
