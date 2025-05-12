<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArtisanController;

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

// Artisan saving/unsaving endpoints
Route::middleware('auth:sanctum')->post('/save-artisan/{id}', [ArtisanController::class, 'saveArtisan']);
Route::middleware('auth:sanctum')->post('/unsave-artisan/{id}', [ArtisanController::class, 'unsaveArtisan']);
