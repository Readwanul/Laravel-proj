<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

Route::post('/register', [ UserController::class, 'register']);
Route::get('/users', [ UserController::class, 'getall']);
Route::post('login', [ UserController::class, 'login']);
Route::post('/reset-password', [ UserController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::middleware('auth:sanctum')->get('/users', [ UserController::class, 'getall']);
Route::middleware('auth:sanctum')->post('/UpdateUser', [ UserController::class, 'update']);
Route::middleware('auth:sanctum')->post('/deleteUser', [ UserController::class, 'delete']);
Route::middleware('auth:sanctum')->post('/getbyid', [ UserController::class, 'getbyid']);
