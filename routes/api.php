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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group([
    'prefix' => 'company',
    'middleware' => 'auth:sanctum'
], function () {
    // Company API
Route::get('company', [CompanyController::class, 'all']);

// company create
Route::post('company', [CompanyController::class, 'create']);

// company update
Route::put('company', [CompanyController::class, 'update']);
}
);

// Company API
// Route::get('company', [CompanyController::class, 'all']);

// company create
// Route::post('company', [CompanyController::class, 'create'])->middleware('auth:sanctum');

// company update
// Route::put('company', [CompanyController::class, 'update'])->middleware('auth:sanctum');


// Auth API
// login (mengirim sesuatu dan mendapatkan sesuatu)
Route::post('login', [UserController::class, 'login']);

// register (mengirim sesuatu dan mendapatkan sesuatu)
Route::post('register', [UserController::class, 'register']);

// logout (mengirim sesuatu dan mendapatkan sesuatu)
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

// fetch
Route::get('user', [UserController::class, 'fetch'])->middleware('auth:sanctum');
