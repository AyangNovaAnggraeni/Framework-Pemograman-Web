<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return 'hallo dunia';
});

Route::get('/dashboard', function () {
    return 'this is dashboard';
})->middleware('auth');

Route::get('/user/{id}', function ($id) {
    return "User ID: " . $id;
});





// Route::get('/profile', function () {
//     return 'This is profile page.';
// })->name('profile');

// Route::get('/redirect-to-profile', function () {
//     return redirect()->route('profile');
// });

// Route::prefix('admin')->group(function () {
//     Route::get('/dashboard', function () {
//         return 'This is admin dashboard.';
//     });

//     Route::get('/profile', function () {
//         return 'This is admin profile.';
//     });
// });



// Route::get('/product', [ProductController::class, 'product.index']);
// Route::get('/product/create', [ProductController::class, 'product.create']);
// Route::get('/product/{id}', [ProductController::class, 'show']);
// Route::get('/product/{id}/edit', [ProductController::class, 'product.edit']);
// Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
// Route::get('/product/{id}', [ProductController::class, 'product.update']);
// Route::delete('/product/{id}', [ProductController::class, 'product.destroy']);

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
})->middleware(['auth', 'role:admin']);

Route::get('/user-only', function () {
    return "Hello User!";
})->middleware(['auth', 'role:user']);

Route::get('/product/create', [ProductController::class, 'create'])
    ->name('product.index')
    ->middleware(['auth', 'role:admin']);
Route::post('/product', [ProductController::class, 'store'])->name('product.store');

Route::get(uri: '/product/{id}', action: [ProductController::class, 'show'])->name(name: "product.detail");

Route::resource('product', ProductController::class)->middleware(['auth', 'role:admin']);

Route::get(uri: '/product/export/excel', action: [ProductController::class, 'exportExcel'])->name(name: 'product.export.excel');


Route::get(uri: '/product/export/pdf', action: [ProductController::class, 'exportPdf'])->name(name: 'export.pdf');

Route::get('/export-product-jpg', [ProductController::class, 'exportJpg'])
    ->name('export.product.jpg');

require __DIR__ . '/auth.php';
