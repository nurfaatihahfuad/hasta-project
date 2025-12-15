<?php

use Illuminate\Support\Facades\Route;
// add controller
use App\Http\Controllers\CustomerRegistrationController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
});

// Customer Registration Routes
Route::get('/register/customer', [CustomerRegistrationController::class, 'create'])
    ->name('customer.register');
    //->middleware('guest');

Route::post('/register/customer', [CustomerRegistrationController::class, 'store'])
    ->name('customer.register.store');

Route::get('/registration/success', [CustomerRegistrationController::class, 'success'])
    ->name('registration.success');
    //->middleware('auth');

// Customer Dashboard
Route::get('/customer/dashboard', function () {
    return view('customers.dashboard');
})->name('customer.dashboard')->middleware(['auth', 'customer']);

// Customer Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');
    
Route::post('/login', [LoginController::class, 'login'])
    ->name('login.submit');
    
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');


