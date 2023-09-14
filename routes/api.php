<?php

use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/company', [CompanyController::class, 'all']);

// login (mengirim sesuatu dan mendapatkan sesuatu)
Route::post('login', [UserController::class, 'login']);

// register (mengirim sesuatu dan mendapatkan sesuatu)
Route::post('register', [UserController::class, 'register']);

// logout (mengirim sesuatu dan mendapatkan sesuatu)
Route::post('logout', [UserController::class, 'logout']);
