<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\shiftAssigment;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'superadmin'])
    ->name('dashboard');
Route::get('superadmin', [SuperAdminController::class, 'index'])
    ->middleware(['auth', 'verified', 'superadmin'])
    ->name('superadmin');
Route::view('asesor', 'asesor')
    ->middleware(['auth', 'verified', 'asesor'])
    ->name('asesor');
Route::view('specialist', 'specialist')
    ->middleware(['auth', 'verified', 'specialist'])
    ->name('specialist');
Route::get('asignshift', [shiftAssigment::class, 'index'])
    ->name('asignshift');
Route::get('visualizationshift', [shiftAssigment::class, 'show'])
    ->name('visualizationshift');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
