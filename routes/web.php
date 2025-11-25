<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'vi'])) {
        Session::put('locale', $locale);
    }

    return redirect()->back();
})->name('lang.switch');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'permission'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Client routes
    Route::resource('clients', ClientController::class);

    // User routes
    Route::resource('users', UserController::class);

    // Product routes
    Route::resource('products', ProductController::class);

    // Invoice routes
    Route::resource('invoices', InvoiceController::class);

    // Ticket routes
    Route::resource('tickets', TicketController::class);
    Route::post('/tickets/{ticket}/reply', [TicketController::class, 'reply'])->name('tickets.reply');
    Route::post('/tickets/{ticket}/merge', [TicketController::class, 'merge'])->name('tickets.merge');

    // Order routes
    Route::resource('orders', OrderController::class);

    // Report routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});

require __DIR__.'/auth.php';
