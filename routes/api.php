<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

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


Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/signin', [AuthController::class, 'signin']);

Route::post('/resetpassword', [AuthController::class, 'resetPassword']);
Route::post('/verifyemail', [AuthController::class, 'verifyEmail']);

// Route::get('/auth/me', [AuthController::class, 'user'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function() {

    Route::get('/auth/me', [AuthController::class, 'user']);
    Route::get('/task', [TaskController::class, 'index']);
    Route::get('/task/{id}', [TaskController::class, 'show']);
    Route::post('/task', [TaskController::class, 'store']);
    Route::put('/task/{id}', [TaskController::class, 'update']);
    Route::delete('/task/{id}', [TaskController::class, 'destroy']);

});
