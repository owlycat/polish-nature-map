<?php

use Illuminate\Foundation\Application;
use \Illuminate\Auth\Middleware\Authorize;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\ImporterController;
use App\Enums\Permissions;

Route::get('/', function () {
    $importer = new App\Importers\NationalParkImporter();

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('index');

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
     Authorize::using(Permissions::VIEW_ADMIN_PANEL->value)
    ]], function ()
    {
        Route::group(['middleware' => [Authorize::using(Permissions::VIEW_IMPORTERS->value)]], function () {
            Route::get('/admin/importers', [ImporterController::class, 'index'])->name('admin.importers.index');
        });

        Route::group(['middleware' => [Authorize::using(Permissions::RUN_IMPORTERS->value)]], function () {
            Route::put('/admin/importers', [ImporterController::class, 'run'])->name('admin.importers.run');
        });
    }
);
