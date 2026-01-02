<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReflectionController;

Route::get('/', function () {
    return view('landing');
})->name('landing');

// Authenticated user dashboard
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Authentication routes
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

Route::get('/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// User routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::post('/reminder/mark-read', [HomeController::class, 'markAsRead'])->name('reminder.mark.read');
    Route::post('/reminder/save-reflection', [HomeController::class, 'saveReflection'])->name('reminder.save.reflection');
    Route::get('/reflections', [ReflectionController::class, 'index'])->name('reflections.index');
    Route::get('/reflections/{id}', [ReflectionController::class, 'show'])->name('reflections.show');
});

// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/reminders/create', [AdminController::class, 'create'])->name('reminders.create');
    Route::post('/reminders', [AdminController::class, 'store'])->name('reminders.store');
    Route::get('/reminders/{id}/edit', [AdminController::class, 'edit'])->name('reminders.edit');
    Route::put('/reminders/{id}', [AdminController::class, 'update'])->name('reminders.update');
    Route::delete('/reminders/{id}', [AdminController::class, 'destroy'])->name('reminders.destroy');
});
