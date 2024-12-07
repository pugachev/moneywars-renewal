<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MoneyController;
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

Route::get('money', [MoneyController::class, 'index'])->name('money.index');
Route::get('money/json/{tgtdate?}', [MoneyController::class, 'getJsonData'])
    ->withoutMiddleware(['verifyCsrfToken'])
    ->name('money.json');
// Route::get('money', [MoneyController::class, 'index'])->name('money.index');
// Route::get('money/json/{tgtdate?}', [MoneyController::class, 'getJsonData'])
//     ->withoutMiddleware(['verifyCsrfToken'])
//     ->name('money.json');

