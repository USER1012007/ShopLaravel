<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\IncluyeController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/api/data', [ExampleController::class, 'fetchData'])->name('fetchData');

Route::get('/admin/data', [AdminController::class, 'fetchData'])->name('fetchData');

Route::get('/admin', function () {
    return Inertia::render('Admin');
})->middleware(['auth', 'verified'])->name('admin');
Route::post('/admin/create', [AdminController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('admin.create');
Route::delete('/admin/data/{id}', [AdminController::class, 'destroy'])->middleware(['auth', 'verified'])->name('admin.destroy');
Route::put('/admin/update/{id}', [AdminController::class, 'update'])->name('update');

Route::post('/sales', [SalesController::class, 'completeSale'])->name('Makesale');
Route::get('/sales', function () {
    return Inertia::render('Compras');
})->middleware(['auth', 'verified'])->name('sales');
Route::get('/sales/data', [SalesController::class, 'fetchData'])->name('fetchData');
Route::get('/sales/data/{userId}', [SalesController::class, 'getSales'])->name('getSales');

Route::get('/compras/data', [IncluyeController::class, 'fetchData'])->name('fetchData');
Route::get('/compras', function () {
    return Inertia::render('compras');
})->middleware(['auth', 'verified'])->name('compras');

require __DIR__.'/auth.php';
