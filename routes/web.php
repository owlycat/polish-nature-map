<?php

use App\Enums\Permissions;
use App\Http\Controllers\Admin\ImporterController;
use App\Http\Controllers\PersonalMapController;
use App\Http\Controllers\SpatialFeatureController;
use App\Http\Controllers\VisitsController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [WelcomeController::class, 'index'])->name('index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::group(['middleware' => [
    'auth:sanctum',
    config('jetstream.auth_session'),
    Authorize::using(Permissions::VIEW_ADMIN_PANEL->value),
]], function () {
    Route::group(['middleware' => [Authorize::using(Permissions::VIEW_IMPORTERS->value)]], function () {
        Route::get('/admin', [ImporterController::class, 'index'])->name('admin.importers.index');
    });

    Route::group(['middleware' => [Authorize::using(Permissions::RUN_IMPORTERS->value)]], function () {
        Route::put('/admin', [ImporterController::class, 'run'])->name('admin.importers.run');
    });
}
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::post('/visits/{placeId}', [VisitsController::class, 'visit']);
    Route::delete('/visits/{placeId}', [VisitsController::class, 'unvisit']);
});

Route::middleware([
    'auth:sanctum',
])->group(function () {
    Route::get('/map/me', [PersonalMapController::class, 'me'])->name('map.me');
    Route::put('/share', [PersonalMapController::class, 'share'])->name('map.share');
});

Route::get('/map/{name}', [PersonalMapController::class, 'show'])->name('map');

Route::get('/features/id/{id}', [SpatialFeatureController::class, 'show']);
Route::get('/features/search', [SpatialFeatureController::class, 'search']);
Route::get('/features/filterIds', [SpatialFeatureController::class, 'filterIds']);
