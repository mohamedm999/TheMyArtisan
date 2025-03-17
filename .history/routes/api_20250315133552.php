<?php

use App\Http\Controllers\Api\ArtisanController;
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

// Artisan routes
Route::get('/artisans', [ArtisanController::class, 'index']);
Route::post('/save-artisan/{id}', [ArtisanController::class, 'saveArtisan'])->middleware('auth:sanctum');
