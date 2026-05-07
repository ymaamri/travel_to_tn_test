<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Public trip listing – anyone can see
Route::get('/trips', [TripController::class, 'index'])->name('trips.index');

// Dashboard – only logged‑in, shows the user's own trips
Route::get('/dashboard', [TripController::class, 'myTrips'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Trip creation
    Route::get('/trips/create', [TripController::class, 'create'])->name('trips.create');
    Route::post('/trips', [TripController::class, 'store'])->name('trips.store');

    // Trip editing
    Route::get('/trips/{trip}/edit', [TripController::class, 'edit'])->name('trips.edit');
    Route::patch('/trips/{trip}', [TripController::class, 'update'])->name('trips.update');

    // Trip deletion
    Route::delete('/trips/{trip}', [TripController::class, 'destroy'])->name('trips.destroy');
});

require __DIR__ . '/auth.php';