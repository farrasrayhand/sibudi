<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuestbookController;

// Redirect root to login if not authenticated
Route::get('/', function () {
    if (session('admin_logged_in')) {
        return redirect()->route('guestbook.index');
    }
    return redirect()->route('login');
})->name('home');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public Guest Form
Route::get('/tamu', [GuestbookController::class, 'publicCreate'])->name('tamu.create');
Route::post('/tamu', [GuestbookController::class, 'publicStore'])->name('tamu.store');

// Guestbook Routes (protected by middleware in controller)
Route::get('/guestbook', [GuestbookController::class, 'index'])->name('guestbook.index');
Route::get('/guestbook/create', [GuestbookController::class, 'create'])->name('guestbook.create');
Route::post('/guestbook', [GuestbookController::class, 'store'])->name('guestbook.store');
Route::get('/guestbook/{id}/edit', [GuestbookController::class, 'edit'])->name('guestbook.edit');
Route::put('/guestbook/{id}', [GuestbookController::class, 'update'])->name('guestbook.update');
Route::delete('/guestbook/{id}', [GuestbookController::class, 'destroy'])->name('guestbook.destroy');
Route::get('/guestbook/export', [GuestbookController::class, 'export'])->name('guestbook.export');

