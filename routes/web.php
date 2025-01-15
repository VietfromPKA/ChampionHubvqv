<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PlayerController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| File định nghĩa các route của ứng dụng web.
*/

// Trang chủ
Route::get('/', fn() => view('home'));

// Các route liên quan đến xác thực
Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); // Hiển thị form đăng nhập
    Route::post('/login', [AuthController::class, 'login']); // Xử lý đăng nhập
    Route::get('/signin', [AuthController::class, 'showRegisterForm'])->name('signin'); // Hiển thị form đăng ký
    Route::post('/signin', [AuthController::class, 'register']); // Xử lý đăng ký
    Route::post('/logout', function () {
        Auth::logout(); // Xử lý logout
        return redirect('/'); // Trả về trang chủ
    })->name('logout');

});

// Các route liên quan đến giải đấu
Route::resource('tournaments', TournamentController::class); // Định nghĩa các route CRUD cho giải đấu
Route::get('/tournaments/all', [TournamentController::class, 'showAll'])->name('tournaments.all'); // Hiển thị tất cả giải đấu

Route::prefix('tournament')->name('tournament.')->group(function () {
    Route::get('/', [TournamentController::class, 'index'])->name('index'); // Hiển thị danh sách giải đấu
    Route::get('create', [TournamentController::class, 'create'])->name('create'); // Hiển thị form tạo giải đấu
    Route::post('store', [TournamentController::class, 'store'])->name('store'); // Lưu giải đấu mới
    Route::get('{id}/edit', [TournamentController::class, 'edit'])->name('edit'); // Hiển thị form chỉnh sửa giải đấu
    Route::put('{id}', [TournamentController::class, 'update'])->name('update'); // Cập nhật thông tin giải đấu
    Route::delete('{id}', [TournamentController::class, 'destroy'])->name('destroy'); // Xóa giải đấu
    Route::get('/{id}', [TournamentController::class, 'show'])->name('show'); // Hiển thị chi tiết giải đấu
});

Route::resource('games', GameController::class)->middleware('auth');
// Các route liên quan đến đội bóng
Route::prefix('team')->name('team.')->group(function () {
    Route::get('/', [TeamController::class, 'index'])->name('index'); // Hiển thị danh sách đội bóng
    Route::get('create', [TeamController::class, 'create'])->name('create'); // Hiển thị form tạo đội bóng
    Route::post('store', [TeamController::class, 'store'])->name('store'); // Lưu đội bóng mới
    Route::get('{id}/edit', [TeamController::class, 'edit'])->name('edit'); // Hiển thị form chỉnh sửa đội bóng
    Route::put('{id}', [TeamController::class, 'update'])->name('update'); // Cập nhật thông tin đội bóng
    Route::delete('{id}', [TeamController::class, 'destroy'])->name('destroy'); // Xóa đội bóng
});

// Các route yêu cầu người dùng phải đăng nhập
Route::middleware(['auth'])->group(function () {
    Route::get('/tournaments', [TournamentController::class, 'index'])->name('tournaments.index'); // Hiển thị danh sách giải đấu (yêu cầu đăng nhập)
    Route::get('/teams', [TeamController::class, 'index'])->name('team.index'); // Hiển thị danh sách đội bóng (yêu cầu đăng nhập)
});

// Các route cho lịch thi đấu
Route::prefix('games')->name('games.')->group(function () {
    Route::get('/', [GameController::class, 'index'])->name('index'); // Danh sách tất cả các trận đấu
    Route::get('create', [GameController::class, 'create'])->name('create'); // Form tạo trận đấu mới
    Route::post('store', [GameController::class, 'store'])->name('store'); // Lưu thông tin trận đấu
    Route::get('{id}', [GameController::class, 'show'])->name('show'); // Chi tiết trận đấu
    Route::get('{id}/edit', [GameController::class, 'edit'])->name('edit'); // Form chỉnh sửa trận đấu
    Route::put('{id}', [GameController::class, 'update'])->name('update'); // Cập nhật trận đấu
    Route::delete('{id}', [GameController::class, 'destroy'])->name('destroy'); // Xóa trận đấu
});

Route::get('/profile', [AuthController::class, 'profile'])->name('user.index');
Route::get('/tournaments', [PublicController::class, 'tournament'])->name('public.tournaments.index');
Route::get('/list_teams', [PublicController::class, 'team'])->name('public.teams.index');
Route::get('/publictournaments/{id}', [PublicController::class, 'showTournament'])->name('public.tournaments.show');


Route::prefix('teams/{teamId}/players')->name('players.')->group(function () {
    Route::get('/', [PlayerController::class, 'index'])->name('index'); // Danh sách cầu thủ
    Route::get('/create', [PlayerController::class, 'create'])->name('create'); // Thêm cầu thủ
    Route::post('/store', [PlayerController::class, 'store'])->name('store'); // Lưu cầu thủ
});

