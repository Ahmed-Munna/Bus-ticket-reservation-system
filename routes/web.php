<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

// Authentication Routes

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::view('/forgot-password', 'auth.forgot-password')->name('forgot-password');

Route::controller(AuthController::class)->group(function () {
    
    Route::post('/user/register', 'register')->name('user.register');
    Route::post('/user/login', 'login')->name('user.login');
    Route::post('/send-otp', 'sendOtp')->name('send.otp');
    Route::post('/verify-otp', 'verifyOtp')->name('verify.otp');

    Route::middleware('auth:sanctum')->group(function () {
    
        Route::post('/user/logout', 'logout')->name('user.logout');
        Route::post('/reset-password', 'resetPassword')->name('reset.password');
    });
});

