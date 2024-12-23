<?php

use App\Http\Controllers\EmailVerificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('welcome');

Route::get('/settings', function () {
    return view('/profile/settings');
})->name('settings');


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('posts', PostController::class);
});

Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
//Route::get('/posts/{id}', [PostController::class, 'store'])->name('posts.show');

Route::post('forget-password', [PasswordResetController::class, 'sendResetLink'])
    ->name('forget-password.request');

Route::get('/forget-password', function () {
    return view('auth.forget-password');
})->name('forget-password');


Route::post('password/email', [PasswordResetController::class, 'sendResetLink'])->name('password.email');

Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');

Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.reset.submit');

Route::get('/email/verify/{token}', [EmailVerificationController::class, 'showVerifyForm'])->name('email.verify.form');

Route::post('/email/verify', [EmailVerificationController::class, 'verifyEmail'])->name('email.verify');

Route::middleware('auth')->group(function () {
    Route::post('/admin/assign-roles', [\App\Filament\Pages\AssignRoles::class, 'assignRole'])->name('assign.roles');
});

Route::post('/admin/assign-role/{user}', [\App\Filament\Pages\AssignRoles::class, 'assignRole'])->name('assign.roles');

