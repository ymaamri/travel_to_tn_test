<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\Admin\TransportInfoController;
use App\Http\Controllers\ItineraryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Public trip listing – anyone can see
Route::get('/trips', [TripController::class, 'index'])->name('trips.index');
Route::get('/trips/{trip}', [TripController::class, 'show'])->name('trips.show');

// Public blog routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Public destination routes
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{slug}', [DestinationController::class, 'show'])->name('destinations.show');

// Public activities routes
Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
Route::get('/activities/{slug}', [ActivityController::class, 'show'])->name('activities.show');

// Public establishment (hotels & restaurants) routes
Route::get('/directory', [EstablishmentController::class, 'index'])->name('directory.index');
Route::get('/directory/{slug}', [EstablishmentController::class, 'show'])->name('directory.show');

// Public transportation guides (from database)
Route::get('/transport', [TransportController::class, 'index'])->name('transport.index');
Route::get('/transport/{slug}', [TransportController::class, 'show'])->name('transport.show');

// Dashboard – only logged‑in, shows the user's own trips
Route::get('/dashboard', [TripController::class, 'myTrips'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ========== SAVED ITINERARIES PAGE (MUST BE BEFORE AUTH GROUP) ==========
Route::get('/saved-itineraries', function () {
    return view('my-itineraries');
})->middleware(['auth'])->name('saved-itineraries');

// Trip Planner page
Route::get('/planner', function () {
    return view('planner');
})->name('planner');

// ========== INTERACTIVE MAP PAGE ==========
Route::get('/explore-map', function () {
    return view('explore-map');
})->name('explore-map');

// ========== MAP MARKERS API (TEMPORARY ROUTE) ==========
Route::get('/map-markers', [App\Http\Controllers\Api\MapController::class, 'markers']);

// Trip Planner API route
Route::post('/api/trip-planner/generate', [App\Http\Controllers\Api\TripPlannerController::class, 'generate']);

// ========== AUTHENTICATED ROUTES ==========
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Trip management
    Route::get('/trips/create', [TripController::class, 'create'])->name('trips.create');
    Route::post('/trips', [TripController::class, 'store'])->name('trips.store');
    Route::get('/trips/{trip}/edit', [TripController::class, 'edit'])->name('trips.edit');
    Route::patch('/trips/{trip}', [TripController::class, 'update'])->name('trips.update');
    Route::delete('/trips/{trip}', [TripController::class, 'destroy'])->name('trips.destroy');

    // Review routes
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::patch('/reviews/{review}/verify', [ReviewController::class, 'verify'])->name('reviews.verify');

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/blogs', [BlogController::class, 'adminIndex'])->name('blogs.index');
        Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
        Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
        Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
        Route::patch('/blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update');
        Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');

        Route::get('/destinations', [DestinationController::class, 'adminIndex'])->name('destinations.index');
        Route::get('/destinations/create', [DestinationController::class, 'create'])->name('destinations.create');
        Route::post('/destinations', [DestinationController::class, 'store'])->name('destinations.store');
        Route::get('/destinations/{destination}/edit', [DestinationController::class, 'edit'])->name('destinations.edit');
        Route::patch('/destinations/{destination}', [DestinationController::class, 'update'])->name('destinations.update');
        Route::delete('/destinations/{destination}', [DestinationController::class, 'destroy'])->name('destinations.destroy');
        Route::delete('/destinations/{destination}/remove-image', [DestinationController::class, 'removeImage'])->name('destinations.remove-image');

        Route::get('/activities', [ActivityController::class, 'adminIndex'])->name('activities.index');
        Route::get('/activities/create', [ActivityController::class, 'create'])->name('activities.create');
        Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
        Route::get('/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
        Route::patch('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
        Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');
        Route::delete('/activities/{activity}/remove-image', [ActivityController::class, 'removeImage'])->name('activities.remove-image');

        Route::get('/establishments', [EstablishmentController::class, 'adminIndex'])->name('establishments.index');
        Route::get('/establishments/create', [EstablishmentController::class, 'create'])->name('establishments.create');
        Route::post('/establishments', [EstablishmentController::class, 'store'])->name('establishments.store');
        Route::get('/establishments/{establishment}/edit', [EstablishmentController::class, 'edit'])->name('establishments.edit');
        Route::patch('/establishments/{establishment}', [EstablishmentController::class, 'update'])->name('establishments.update');
        Route::delete('/establishments/{establishment}', [EstablishmentController::class, 'destroy'])->name('establishments.destroy');
        Route::delete('/establishments/{establishment}/remove-image', [EstablishmentController::class, 'removeImage'])->name('establishments.remove-image');

        Route::get('/transport', [TransportInfoController::class, 'index'])->name('transport.index');
        Route::get('/transport/create', [TransportInfoController::class, 'create'])->name('transport.create');
        Route::post('/transport', [TransportInfoController::class, 'store'])->name('transport.store');
        Route::get('/transport/{transportInfo}/edit', [TransportInfoController::class, 'edit'])->name('transport.edit');
        Route::patch('/transport/{transportInfo}', [TransportInfoController::class, 'update'])->name('transport.update');
        Route::delete('/transport/{transportInfo}', [TransportInfoController::class, 'destroy'])->name('transport.destroy');
        Route::delete('/transport/{transportInfo}/remove-image', [TransportInfoController::class, 'removeImage'])->name('transport.remove-image');
    });

    // Itinerary API routes (must be after auth middleware)
    Route::get('/my-itineraries', [ItineraryController::class, 'index']);
    Route::post('/itineraries', [ItineraryController::class, 'store'])->name('itineraries.store');
    Route::get('/itineraries/{id}', [ItineraryController::class, 'show']);
    Route::delete('/itineraries/{id}', [ItineraryController::class, 'destroy']);
});

require __DIR__ . '/auth.php';