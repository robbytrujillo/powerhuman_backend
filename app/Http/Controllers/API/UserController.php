<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    public function login(Request $request) {
        try {
            // Validate Request
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
        
            // Find User By Email
            // $credentials = request(['email', 'password']);
            // if (!Auth::attempt($credentials)) {
            //     return ResponseFormatter::error('Unauthorized', 401);
            // }

            $user = User::where('email', $request->email)->firstOrFail();
            if (!Hash::check($request->password, $user->password)) {
                throw new Exception('Invalid password');
            }

            // Generate Token
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            
        
            // Return Response
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Login success');
            
        }catch (Exception $error) {
            return ResponseFormatter::error($error -> getMessage());
        }

    }

    public function register (Request $request) {
        try {
            // Validate Request
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', new Password],
            ]);

            // Create User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Generate Token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // Return Response
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Register success');

        } catch (Exception $error) {
            // Return Error Response
            return ResponseFormatter::error($error->getMessage());
        }
    }

    public function logout(Request $request) {
        // Revoke Token
        $token = $request->user()->currentAccessToken()->delete();

        // Return Response
        return ResponseFormatter::success($token, 'Logout success');
    }

    public function fetch(Request $request) {
        // Get User
        $user = $request->user();

        // Return Response
        return ResponseFormatter::success($user, 'Fetch Success');

    }
}
