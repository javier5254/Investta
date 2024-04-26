<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\RolController;
use App\Http\Controllers\Api\ClientServedController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ShiftController;

// Rutas para el controlador UserController
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::post('/user', [UserController::class, 'store']);
Route::patch('/user/{id}', [UserController::class, 'update']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);

// Rutas para el controlador LocationController
Route::get('/location', [LocationController::class, 'index']);
Route::get('/location/{id}', [LocationController::class, 'show']);
Route::post('/location', [LocationController::class, 'store']);
Route::patch('/location/{id}', [LocationController::class, 'update']);
Route::delete('/location/{id}', [LocationController::class, 'destroy']);

// Rutas para el controlador RoleController
Route::get('/rol', [RolController::class, 'index']);
Route::get('/rol/{id}', [RolController::class, 'show']);
Route::post('/rol', [RolController::class, 'store']);
Route::patch('/rol/{id}', [RolController::class, 'update']);
Route::delete('/rol/{id}', [RolController::class, 'destroy']);

// Rutas para el controlador ClientServedController
Route::get('/client-served', [ClientServedController::class, 'index']);
Route::get('/client-served/{id}', [ClientServedController::class, 'show']);
Route::post('/client-served', [ClientServedController::class, 'store']);
Route::patch('/client-served/{id}', [ClientServedController::class, 'update']);
Route::delete('/client-served/{id}', [ClientServedController::class, 'destroy']);

// Rutas para el controlador PatientController
Route::get('/patient', [PatientController::class, 'index']);
Route::get('/patient/{id}', [PatientController::class, 'show']);
Route::post('/patient', [PatientController::class, 'store']);
Route::patch('/patient/{id}', [PatientController::class, 'update']);
Route::delete('/patient/{id}', [PatientController::class, 'destroy']);

// Rutas para el controlador ServiceController
Route::get('/service', [ServiceController::class, 'index']);
Route::get('/service/{id}', [ServiceController::class, 'show']);
Route::post('/service', [ServiceController::class, 'store']);
Route::patch('/service/{id}', [ServiceController::class, 'update']);
Route::delete('/service/{id}', [ServiceController::class, 'destroy']);

// Rutas para el controlador ShiftController
Route::get('/shift', [ShiftController::class, 'index']);
Route::get('/shift/{id}', [ShiftController::class, 'show']);
Route::post('/shift', [ShiftController::class, 'store']);
Route::patch('/shift/{id}', [ShiftController::class, 'update']);
Route::delete('/shift/{id}', [ShiftController::class, 'destroy']);
