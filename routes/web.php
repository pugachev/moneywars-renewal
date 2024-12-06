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
// Route::resource('money', MoneyController::class);
Route::get('/', function () {
    return redirect('/money');
});
// Route::get('/', [MoneyController::class, 'index'])->name('money.index');
Route::get('money', [MoneyController::class, 'index'])->name('money.index');
Route::get('money/json', [MoneyController::class, 'getJsonData'])->withoutMiddleware(['verifyCsrfToken'])->name('money.json');
Route::get('money/create', [MoneyController::class, 'create'])->name('money.create');
Route::post('money', [MoneyController::class, 'store'])->name('money.store');
Route::get('money/{money}', [MoneyController::class, 'show'])->name('money.show');
Route::get('money/{money}/edit', [MoneyController::class, 'edit'])->name('money.edit');
Route::patch('money/update', [MoneyController::class, 'update'])->name('money.update');
Route::post('money/destroy', [MoneyController::class, 'destroy'])->name('money.destroy');
Route::post('money/preweek', [MoneyController::class, 'preweek'])->name('money.preweek');
Route::post('money/nextweek', [MoneyController::class, 'nextweek'])->name('money.nextweek');
// Auth::routes();
// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';
