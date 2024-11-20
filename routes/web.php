<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/book', [BookController::class, 'index'])->name('book');
});

Route::group(['middleware' => ['role:pustakawan']], function () {
    Route::get('/book/create', [BookController::class, 'create'])->name('book.create');
    Route::get('/book/edit/{id}', [BookController::class, 'edit'])->name('book.edit');
    Route::post('/book/store', [BookController::class, 'store'])->name('book.store');
    Route::patch('/book/{id}/update', [BookController::class, 'update'])->name('book.update');
    Route::delete('/book/{id}/delete', [BookController::class, 'destroy'])->name('book.destroy');
});

require __DIR__.'/auth.php';
