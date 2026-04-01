<?php

use App\Http\Controllers\InstallController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ── Install Wizard ────────────────────────────────────────────
Route::prefix('install')->name('install.')->middleware(\App\Http\Middleware\RedirectIfInstalled::class)->group(function () {
    Route::get('/',            [InstallController::class, 'index'])->name('index');
    Route::get('/database',    [InstallController::class, 'databaseForm'])->name('database');
    Route::post('/database',   [InstallController::class, 'databaseStore'])->name('database.store');
    Route::get('/admin',       [InstallController::class, 'adminForm'])->name('admin');
    Route::post('/admin',      [InstallController::class, 'adminStore'])->name('admin.store');
    Route::get('/run',         [InstallController::class, 'runForm'])->name('run-form');
    Route::post('/run',        [InstallController::class, 'runInstall'])->name('run');
    Route::get('/complete',    [InstallController::class, 'complete'])->name('complete');
});
