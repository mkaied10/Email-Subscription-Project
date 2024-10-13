<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TestController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;


Route::get('/', [SubscriptionController::class, 'index'])->name('home');

// subscription 
Route::controller(SubscriptionController::class)->group(function() {
    Route::get('/subscribe', 'index')->name('subscription.index');
    Route::post('/subscribe', 'store')->name('subscription.store');
});



