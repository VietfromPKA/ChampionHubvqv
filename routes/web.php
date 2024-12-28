<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Auth;

/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signin', [AuthController::class, 'showRegisterForm'])->name('signin');
Route::post('/signin', [AuthController::class, 'register']);

// Đăng xuất
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // Quay về trang chủ sau khi đăng xuất
})->name('logout');

// Các route cho giải đấu
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
// routes/web.php
Route::get('/tournaments/all', [TournamentController::class, 'showAll'])->name('tournaments.all');


// Các route cho đội bóng
Route::prefix('team')->name('team.')->group(function() {
    Route::get('/', [TeamController::class, 'index'])->name('index'); // Danh sách đội bóng
    Route::get('create', [TeamController::class, 'create'])->name('create'); // Form thêm đội bóng
    Route::post('store', [TeamController::class, 'store'])->name('store'); // Lưu đội bóng mới
    Route::get('{id}/edit', [TeamController::class, 'edit'])->name('edit'); // Sửa đội bóng
    Route::put('{id}', [TeamController::class, 'update'])->name('update'); // Cập nhật đội bóng
    Route::delete('{id}', [TeamController::class, 'destroy'])->name('destroy'); // Xóa đội bóng
});

// Đảm bảo rằng người dùng phải đăng nhập mới được truy cập
Route::middleware(['auth'])->group(function () {
    Route::get('/tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
    Route::get('/teams', [TeamController::class, 'index'])->name('team.index');
});
