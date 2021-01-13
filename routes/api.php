<?php

use App\Http\Controllers\HighscoreController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\RegistrationController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/registration', [RegistrationController::class, 'store']);

Route::post('/login', [LoginController::class, 'login']);
Route::delete('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/maps', [MapController::class, 'index'])->middleware('auth:sanctum');
Route::post('/map', [MapController::class, 'show'])->middleware('auth:sanctum');

Route::get('/highscores', [HighscoreController::class, 'index']);
Route::get('/highscore/{mapId}', [HighscoreController::class, 'getById'])->middleware('auth:sanctum');
Route::post('/highscores', [HighscoreController::class, 'store'])->middleware('auth:sanctum');

