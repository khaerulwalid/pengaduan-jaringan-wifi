<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SLAController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CSTicketController;
use App\Http\Controllers\TechnicianController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function() {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    // Tambahkan edit dan delete
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/sla', [SLAController::class, 'index'])->name('sla.index');
    Route::get('/sla/create', [SLAController::class, 'create'])->name('sla.create');
    Route::post('/sla', [SLAController::class, 'store'])->name('sla.store');
    // Tambahkan edit dan delete
    Route::get('/sla/{sla}/edit', [SLAController::class, 'edit'])->name('sla.edit');
    Route::put('/sla/{sla}', [SLAController::class, 'update'])->name('sla.update');
    Route::delete('/sla/{sla}', [SLAController::class, 'destroy'])->name('sla.destroy');

    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    // Tambahkan edit dan delete
    Route::get('/tickets/{id}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');

    // Route khusus untuk CS
    Route::middleware(['role:cs'])->group(function () {
        Route::get('/cs/tickets', [CSTicketController::class, 'index'])->name('cs.tickets.index');
        Route::get('/cs/tickets/{id}', [CSTicketController::class, 'show'])->name('cs.tickets.show');
        // Route untuk mengupdate priority dan assigned_to
        Route::get('/cs/tickets/{id}/edit', [CSTicketController::class, 'edit'])->name('cs.tickets.edit');
        Route::put('/cs/tickets/{id}', [CSTicketController::class, 'update'])->name('cs.tickets.update');
        Route::put('/cs/tickets/{id}/status', [CSTicketController::class, 'updateStatus'])->name('cs.tickets.updateStatus');

    });

    // Tambahkan route untuk teknisi
    Route::middleware(['auth', 'role:technician'])->group(function() {
        Route::get('/technician/tickets', [TechnicianController::class, 'index'])->name('technician.tickets.index');

        // Route untuk halaman edit pengaduan
        Route::get('/technician/tickets/{ticket}/edit', [TechnicianController::class, 'edit'])->name('technician.tickets.edit');
    });
});




