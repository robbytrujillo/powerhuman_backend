<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
                return ResponseFormatter::error('Unauthorized', 401);
            }

            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password)) {
                throw new Exception('Invalid password');
            }

            // TODO: Generate Token
            $tokenResult = $user->createToen('authToken')->plainTextToken;
            
        
            // TODO: Return Response
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Login success');
            
        }catch (Exception $e) {
            return ResponseFormatter::error('Authentication Failed');
        }

    }
}
