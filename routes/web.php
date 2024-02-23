<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\PeriodicoController::class, 'home'])->name('home');
Route::get('/paper/create', [\App\Http\Controllers\PeriodicoController::class, 'create'])->name('paper.create');
Route::post('/paper/create', [\App\Http\Controllers\PeriodicoController::class, 'store'])->name('paper.store');
Route::get('/papers', [\App\Http\Controllers\PeriodicoController::class, 'papers'])->name('papers');
Route::get('/paper/{slug}', [\App\Http\Controllers\PeriodicoController::class, 'detail'])->name('paper.detail');

Route::get('/dashboard', function () {
    return app(\App\Http\Controllers\PeriodicoController::class)->getAllTitulares();
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
