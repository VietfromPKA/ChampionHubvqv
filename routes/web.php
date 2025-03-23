<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\StadiumController;
use App\Http\Controllers\StadiumImageController;
use App\Http\Controllers\MatchScheduleController;
use App\Http\Middleware\AuthMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| File định nghĩa các route của ứng dụng web.
*/

// Các route liên quan đến auth
Route::prefix('auth')->group(function () {
    // Đăng nhập
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');                          
    Route::post('/login', [AuthController::class, 'login']);                                            

    // Đăng ký
    Route::get('/signin', [AuthController::class, 'showRegisterForm'])->name('signin');                 
    Route::post('/signin', [AuthController::class, 'register']);                              

    //Xác thực email
    Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verifyEmail');

    // Đăng xuất
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Quên mật khẩu
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.forgot');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');     

    // Đặt lại mật khẩu
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');              
});



// Các route liên quan đến thông tin public
Route::get('/', fn() => view('public.tournaments.index'));
Route::get('/list_tournament', [TournamentController::class, 'tournament'])->name('public.tournaments.index');
Route::get('/list_team', [TeamController::class, 'team'])->name('public.teams.index');
Route::get('/list_stadium', [StadiumController::class, 'stadium'])->name('public.stadiums.index');


// Các route liên quan đến tournament
Route::resource('tournaments', TournamentController::class);

// Các route liên quan đến team
Route::resource('teams', TeamController::class);

//Các route liên quan đến stadium
Route::resource('stadiums', StadiumController::class);
Route::post('/stadiums/{id}/upload-image', [StadiumController::class, 'uploadImage'])->name('stadiums.uploadImage');
Route::post('/stadium/{stadiumId}/images', [StadiumImageController::class, 'store'])->name('stadium.images.store');
Route::get('/stadium/{stadiumId}/images', [StadiumImageController::class, 'show'])->name('stadium.images.show');
Route::delete('/stadiums/image/{image}', [StadiumController::class, 'deleteImage'])->name('stadiums.deleteImage');

// Các route liên quan đến match
Route::resource('matches', MatchScheduleController::class);
Route::post('/matches/update-score', [MatchScheduleController::class, 'updateScore'])->name('matches.updateScore'); // cập nhật tỉ số trận đấu

// Các route liên quan đến player



Route::prefix('/teams/{team_id}/players')->group(function () {
    Route::get('/', [PlayerController::class, 'index'])->name('players.index');
    Route::get('/create', [PlayerController::class, 'create'])->name('players.create');
    Route::post('/', [PlayerController::class, 'store'])->name('players.store');
    Route::get('/{player}/edit', [PlayerController::class, 'edit'])->name('players.edit');
    Route::put('/{player}', [PlayerController::class, 'update'])->name('players.update');
    Route::delete('/{player}', [PlayerController::class, 'delete'])->name('players.destroy');
    Route::get('/import', [PlayerController::class, 'showImportForm'])->name('players.importForm');
    Route::post('/import', [PlayerController::class, 'import'])->name('players.import');
});


// Các route liên quan đến user
Route::get('/profile', [UserController::class, 'profile'])->name('user.index');