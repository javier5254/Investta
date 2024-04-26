<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\shiftAssigmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'superadmin'])
    ->name('dashboard');

Route::view('asesor', 'asesor')
    ->middleware(['auth', 'verified', 'asesor'])
    ->name('asesor');

Route::view('specialist', 'specialist')
    ->middleware(['auth', 'verified', 'specialist'])
    ->name('specialist');

Route::get('superadmin', [SuperAdminController::class, 'index'])
    ->middleware(['auth', 'verified', 'superadmin'])
    ->name('superadmin');

Route::get('asignshift', [shiftAssigmentController::class, 'index'])
    ->name('asignshift');

Route::get('visualizationshift', [shiftAssigmentController::class, 'show'])
    ->name('visualizationshift');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
