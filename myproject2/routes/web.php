<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/product', [ProductController::class, 'index']);
// Route::get('/product/create', [ProductController::class, 'create']);
// Route::get('/product', [ProductController::class, 'store']);
// Route::get('/product/{id}', [ProductController::class, 'show']);
// Route::get('/product/{id}/edit', [ProductController::class, 'edit']);
// Route::get('/product/{id}', [ProductController::class, 'update']);
// Route::get('/product/{id}', [ProductController::class, 'destroy']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'verified', 'role:admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// checking role
Route::get('/admin-only', function () {
    return "Hello Admin!";
})->middleware(['auth','role:admin']);

Route::get('/user-only', function () {
    return "Hello User!";
})->middleware(['auth','role:user']);

Route::get('/product/create', [ProductController::class, 'create'])
    ->name('product-create')
    ->middleware(['auth', 'role:admin']);
Route::post('/product', [ProductController::class, 'store'])->name('product-store');

require __DIR__.'/auth.php';
