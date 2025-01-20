<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\CheckAdminOrModerator;
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

Route::post('forget-password', [PasswordResetController::class, 'sendResetLink'])
    ->name('forget-password.request');

Route::get('/forget-password', function () {
    return view('auth.forget-password');
})->name('forget-password');


Route::post('password/email', [PasswordResetController::class, 'sendResetLink'])->name('password.email');

Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');

Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.reset.submit');

Route::get('/email/verify/form', [EmailVerificationController::class, 'showVerifyForm'])->name('email.verify.form');

Route::post('/email/verify', [EmailVerificationController::class, 'verifyEmail'])->name('email.verify');

Route::middleware('auth')->group(function () {
    Route::post('/admin/assign-roles', [\App\Filament\Pages\AssignRoles::class, 'assignRole'])->name('assign.roles');
});

Route::post('/admin/assign-role/{user}', [\App\Filament\Pages\AssignRoles::class, 'assignRole'])->name('assign.roles');

Route::delete('/users/{user}/remove', [\App\Filament\Pages\AssignRoles::class, 'destroy'])->name('remove.user');

Route::resource('products', ProductController::class);

Route::middleware(CheckAdminOrModerator::class)->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
});


Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.add');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.remove');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');


Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');


Route::post('/wishlist/{product}', [WishlistController::class, 'store'])->name('wishlist.add');
Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.remove');

Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');

Route::get('/cart/ordered', [OrderController::class, 'success'])->name('cart.ordered');

Route::middleware(['auth'])->group(function () {
    Route::get('/address', [AddressController::class, 'index'])->name('address.index');
    Route::get('/address/add', [AddressController::class, 'create'])->name('address.add');
    Route::post('/address/store', [AddressController::class, 'store'])->name('address.store');
    Route::get('/address/{id}/edit', [AddressController::class, 'edit'])->name('address.edit');
    Route::put('/address/{id}/update', [AddressController::class, 'update'])->name('address.update');
});
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
