<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TeamController;

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


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signin', [AuthController::class, 'showRegisterForm'])->name('signin');
Route::post('/signin', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::resource('tournaments', TournamentController::class);
Route::prefix('tournament')->name('tournament.')->group(function() {
    Route::get('/', [TournamentController::class, 'index'])->name('index');
    Route::get('create', [TournamentController::class, 'create'])->name('create');
    Route::post('store', [TournamentController::class, 'store'])->name('store');
    Route::get('{id}/edit', [TournamentController::class, 'edit'])->name('edit');
    Route::put('{id}', [TournamentController::class, 'update'])->name('update');
    Route::delete('{id}', [TournamentController::class, 'destroy'])->name('destroy');
    Route::get('/tournaments/{id}', [TournamentController::class, 'show'])->name('tournaments.show');
});
// Định nghĩa các route cho đội bóng
Route::prefix('team')->name('team.')->group(function() {
    Route::get('/', [TeamController::class, 'index'])->name('index'); // Danh sách đội bóng
    Route::get('create', [TeamController::class, 'create'])->name('create'); // Form thêm đội bóng
    Route::post('store', [TeamController::class, 'store'])->name('store'); // Lưu đội bóng mới
    Route::get('{id}/edit', [TeamController::class, 'edit'])->name('edit'); // Sửa đội bóng
    Route::put('{id}', [TeamController::class, 'update'])->name('update'); // Cập nhật đội bóng
    Route::delete('{id}', [TeamController::class, 'destroy'])->name('destroy'); // Xóa đội bóng
});

Route::middleware(['auth'])->group(function () {
    Route::get('/tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
});
