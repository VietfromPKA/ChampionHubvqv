<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TournamentController;

// Ensure that the TournamentController class exists in the App\Http\Controllers namespace
// If it does not exist, create it using the following command:
// php artisan make:controller TournamentController


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});
Route::get('/login', function () {
    return view('auth.login'); // Trả về view 'login'
})->name('login');

Route::get('/signin', function () {
    return view('auth.signin'); // Trả về view 'signin'
})->name('signin');

Route::resource('tournaments', TournamentController::class);
Route::prefix('tournament')->name('tournament.')->group(function() {
    Route::get('/', [TournamentController::class, 'index'])->name('index');
    Route::get('create', [TournamentController::class, 'create'])->name('create');
    Route::post('store', [TournamentController::class, 'store'])->name('store');
    Route::get('{id}/edit', [TournamentController::class, 'edit'])->name('edit');
    Route::put('{id}', [TournamentController::class, 'update'])->name('update');
    Route::delete('{id}', [TournamentController::class, 'destroy'])->name('destroy');
});
