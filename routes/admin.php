<?php

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GuestbookController;
use App\Http\Controllers\Admin\HallOfFameController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\Admin\TimelineController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Dashboard - accessible by admin & developer
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:admin,developer')
        ->name('dashboard');

    // Bulk delete actions - accessible by admin & developer
    Route::post('/members/bulk-delete', [MemberController::class, 'bulkDestroy'])->name('members.bulkDestroy');
    Route::post('/projects/bulk-delete', [ProjectController::class, 'bulkDestroy'])->name('projects.bulkDestroy');
    Route::post('/gallery/bulk-delete', [GalleryController::class, 'bulkDestroy'])->name('gallery.bulkDestroy');
    Route::post('/events/bulk-delete', [EventController::class, 'bulkDestroy'])->name('events.bulkDestroy');
    Route::post('/timeline/bulk-delete', [TimelineController::class, 'bulkDestroy'])->name('timeline.bulkDestroy');
    Route::post('/hall-of-fame/bulk-delete', [HallOfFameController::class, 'bulkDestroy'])->name('hall-of-fame.bulkDestroy');
    Route::post('/quotes/bulk-delete', [QuoteController::class, 'bulkDestroy'])->name('quotes.bulkDestroy');
    Route::post('/guestbook/bulk-delete', [GuestbookController::class, 'bulkDestroy'])->name('guestbook.bulkDestroy');
    Route::post('/announcements/bulk-delete', [AnnouncementController::class, 'bulkDestroy'])->name('announcements.bulkDestroy');
    Route::post('/users/bulk-delete', [UserController::class, 'bulkDestroy'])->name('users.bulkDestroy');

    // Guestbook Custom Actions - accessible by admin & developer
    Route::post('/guestbook/{guestbook}/approve', [GuestbookController::class, 'approve'])->name('guestbook.approve');
    Route::post('/guestbook/{guestbook}/reject', [GuestbookController::class, 'reject'])->name('guestbook.reject');

    // Resources - accessible by admin & developer
    Route::middleware('role:admin,developer')->group(function () {
        Route::resource('members', MemberController::class);
        Route::resource('projects', ProjectController::class);
        Route::resource('gallery', GalleryController::class);
        Route::resource('events', EventController::class);
        Route::resource('timeline', TimelineController::class);
        Route::resource('hall-of-fame', HallOfFameController::class);
        Route::resource('quotes', QuoteController::class);
        Route::resource('guestbook', GuestbookController::class)->only(['index', 'destroy']);
        Route::resource('announcements', AnnouncementController::class);
    });

    // User Management - restricted to developer only
    Route::middleware('role:developer')->group(function () {
        Route::resource('users', UserController::class);
    });
});
