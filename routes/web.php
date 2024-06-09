<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ProfileUpdateController;
use App\Http\Controllers\Auth\SocialiteLoginController;
use App\Http\Controllers\ManageStaffController;
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

// Socialite Routes
Route::controller(SocialiteLoginController::class)->group(function () {

    Route::get('/auth/{provider}', 'redirectToProvider')->name('auth.google');
    Route::get('/{provider}/callback', 'handleProviderCallback')->name('auth.google.callback');
});

// Authentication Routes

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::view('/forgot-password', 'auth.forgot-password')->name('forgot-password');

Route::controller(AuthController::class)->group(function () {
    
    Route::post('/user/register', 'register')->name('user.register');
    Route::post('/user/login', 'login')->name('user.login');
    Route::post('/send-otp', 'sendOtp')->name('send.otp');
    Route::post('/verify-otp', 'verifyOtp')->name('verify.otp');
    
    });

Route::middleware('auth:sanctum')->group(function () {
    
    Route::controller(AuthController::class)->group(function () {
        
        Route::post('/user/logout',  'logout')->name('user.logout');
        Route::post('/reset-password',  'resetPassword')->name('reset.password');
    });

    Route::controller(ProfileUpdateController::class)->group(function () {

        Route::get('/profile', 'index')->name('profile.index');
        Route::post('/profile/update/{id}', 'updateProfile')->name('profile.update');
    });

    // manage staff routes
    Route::view('/manage-staff/create', 'manage-staff.index')->name('manage-staff.index');
    Route::view('/manage-staff/update', 'manage-staff.update')->name('manage-staff.update');

    Route::controller(ManageStaffController::class)->group(function () {
       
       Route::post('/manage-staff/store', 'store')->name('manage-staff.store'); 
       Route::post('/manage-staff/update/{id}', 'update')->name('manage-staff.update');
       Route::post('/manage-staff/delete/{id}', 'destroy')->name('manage-staff.delete');
       Route::get('/all-area-manager', 'showAllAreaManagers')->name('all-area-manager'); 
       Route::get('/all-counter-manager', 'showAllCounterManagers')->name('all-counter-manager'); 
    });
});


