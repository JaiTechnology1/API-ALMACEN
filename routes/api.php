<?php

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
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransitController;
use App\Http\Controllers\StoreController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Agrega más rutas para la API de tránsito y almacén
Route::middleware('auth:api')->group(function () {
    Route::resource('transits', TransitController::class);
    Route::resource('stores', StoreController::class);
});
