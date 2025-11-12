<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute CRUD Klien, Produk, Invoice
    Route::resource('clients', ClientController::class);
    Route::resource('products', ProductController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/{invoice}/download', [InvoiceController::class, 'downloadPDF'])
         ->name('invoices.download');

    // --- TAMBAHKAN RUTE BARU DI SINI ---
    Route::patch('invoices/{invoice}/status', [InvoiceController::class, 'updateStatus'])
         ->name('invoices.updateStatus');
    // --- AKHIR RUTE BARU ---

    // Rute Pengaturan
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';
