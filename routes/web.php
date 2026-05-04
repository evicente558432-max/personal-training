<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\ClientController;

// ── AUTH ROUTES ──────────────────────────
Route::get('/',          [AuthController::class, 'showLogin']);
Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login'])->name('login.post');
Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

// ── ADMIN ROUTES ─────────────────────────
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard',         [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/trainers',          [AdminController::class, 'trainers'])->name('trainers');
    Route::post('/trainers',         [AdminController::class, 'addTrainer'])->name('trainers.add');
    Route::delete('/trainers/{id}',  [AdminController::class, 'deleteTrainer'])->name('trainers.delete');
    Route::get('/schedules',         [AdminController::class, 'schedules'])->name('schedules');
    Route::delete('/schedules/{id}', [AdminController::class, 'deleteSchedule'])->name('schedules.delete');
    Route::get('/reports',           [AdminController::class, 'reports'])->name('reports');
});

// ── TRAINER ROUTES ────────────────────────
Route::prefix('trainer')->name('trainer.')->middleware('auth')->group(function () {
    Route::get('/dashboard',        [TrainerController::class, 'dashboard'])->name('dashboard');
    Route::get('/schedule',         [TrainerController::class, 'scheduleForm'])->name('schedule');
    Route::post('/schedule',        [TrainerController::class, 'saveSchedule'])->name('schedule.save');
    Route::delete('/schedule/{id}', [TrainerController::class, 'deleteSchedule'])->name('schedule.delete');
});

// ── CLIENT ROUTES ─────────────────────────
Route::prefix('client')->name('client.')->middleware('auth')->group(function () {
    Route::get('/dashboard',     [ClientController::class, 'dashboard'])->name('dashboard');
    Route::get('/schedule',      [ClientController::class, 'viewSchedule'])->name('schedule');
    Route::post('/book/{id}',    [ClientController::class, 'bookSession'])->name('book');
    Route::get('/my-bookings',   [ClientController::class, 'myBookings'])->name('bookings');
    Route::post('/cancel/{id}',  [ClientController::class, 'cancelSession'])->name('cancel');
});