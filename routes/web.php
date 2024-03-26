<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

/*DB::listen(function ($query){
    dump($query->sql);
});*/

Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');

Route::post('/', [NotificationController::class, 'store'])->name('notifications.store');

Route::get('/history', [NotificationController::class, 'showHistory'])->name('notifications.history');

Route::post('/search-by-date', [NotificationController::class, 'searchByDate'])->name('notifications.searchByDate');