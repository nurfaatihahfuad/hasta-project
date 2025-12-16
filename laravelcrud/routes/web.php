<?php

use Illuminate\Support\Facades\Route;
// add controller
use App\Http\Controllers\CustomerRegistrationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Customer Registration Routes
Route::get('/register/customer', [CustomerRegistrationController::class, 'create'])
    ->name('customer.register')
    ->middleware('guest');

Route::post('/register/customer', [CustomerRegistrationController::class, 'store'])
    ->name('customer.register.store');

Route::get('/registration/success', [CustomerRegistrationController::class, 'success'])
    ->name('registration.success')
    ->middleware('auth');

// Customer Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');
    
Route::post('/login', [LoginController::class, 'login'])
    ->name('login.submit');
    
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

// Dashboard Routes
Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/vehicles', [DashboardController::class, 'vehicles'])->name('vehicles');
    Route::get('/vehicle/{id}', [DashboardController::class, 'showVehicle'])->name('vehicle.show');
    Route::get('/vehicle/{id}/book', [DashboardController::class, 'bookVehicle'])->name('vehicle.book');
    Route::post('/vehicle/{id}/book', [DashboardController::class, 'storeBooking'])->name('booking.store');
    Route::get('/bookings', [DashboardController::class, 'bookings'])->name('bookings');
    Route::post('/booking/{id}/cancel', [DashboardController::class, 'cancelBooking'])->name('booking.cancel');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
});


