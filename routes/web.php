<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/dashboard', function () {
    $user = auth()->user();
    
    // Redirect based on role
    if ($user->isDeveloper() || $user->isAdmin()) {
        return redirect('/admin/dashboard');
    }
    
    if ($user->isMember()) {
        return redirect('/member/dashboard');
    }
    
    return redirect('/');
})->middleware(['auth'])->name('dashboard');

// Member dashboard routes
Route::middleware(['auth', 'role:member'])->prefix('member')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Member\DashboardController::class, 'index'])->name('member.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
