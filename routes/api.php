<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('/Periodicos', [ApiController::class, 'Periodicos']);
Route::get('/Titulares/{paperID}', [ApiController::class, 'obtenerTitularesPeriodicoJSON']);
Route::get('/Titulares', [ApiController::class, 'getAllTitulares']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

