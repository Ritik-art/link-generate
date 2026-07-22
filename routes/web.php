<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UrlController;

Route::redirect('/', '/dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/invite', [InvitationController::class, 'create'])->name('invite.create');
    Route::post('/invite', [InvitationController::class, 'store'])->name('invite.store');
    Route::get('/url/create', [UrlController::class, 'create'])->name('url.create');
    Route::post('/url/store', [UrlController::class, 'store'])->name('url.store');
    Route::get('/u/{code}', [UrlController::class, 'redirectUrl'])->name('url.redirect');

});

Route::get('/invite/accept/{token}', [InvitationController::class, 'accept'])->name('invite.accept');
Route::post('/invite/accept/{token}', [InvitationController::class, 'acceptStore'])->name('invite.accept.store');

require __DIR__.'/auth.php';
