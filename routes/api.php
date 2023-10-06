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

// Company API
Route::prefix('company')->middleware('auth:sanctum')->name('company.')->group(function () { 
    // Company API
    Route::get('', [CompanyController::class, 'fetch'])->name('fetch');

    // company create
    Route::post('', [CompanyController::class, 'create'])->name('create');

    // company update
    Route::post('update/{id}', [CompanyController::class, 'update'])->name('update');
}
);


// Route::get('company', [CompanyController::class, 'all']);

// company create
// Route::post('company', [CompanyController::class, 'create'])->middleware('auth:sanctum');

// company update
// Route::put('company', [CompanyController::class, 'update'])->middleware('auth:sanctum');

Route::name('auth.')->group(function() {
    
    // Auth API
    // login (mengirim sesuatu dan mendapatkan sesuatu)
    Route::post('login', [UserController::class, 'login'])->name('login');

    // register (mengirim sesuatu dan mendapatkan sesuatu)
    Route::post('register', [UserController::class, 'register'])->name('register');

    Route::middleware('auth:sanctum')->group(function() {
        
        // logout (mengirim sesuatu dan mendapatkan sesuatu)
        Route::post('logout', [UserController::class, 'logout'])->name(('logout'));
    
        // fetch
        Route::get('user', [UserController::class, 'fetch'])->name('fetch');
        });
});

