<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ProfileUpdateController;
use App\Http\Controllers\Auth\SocialiteLoginController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\ManageStaffController;
use App\Http\Controllers\TicketPriceController;
use App\Http\Controllers\TripsRouteController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Requests\VehicleRequest;
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

    Route::view('/manage-staff/create', 'manage-staff.index')->name('manage.staff.index');
    Route::view('/manage-staff/update', 'manage-staff.update')->name('manage.staff.update');

    Route::controller(ManageStaffController::class)->group(function () {
       
       Route::post('/manage-staff/store', 'store')->name('manage-staff.store'); 
       Route::post('/manage-staff/update/{id}', 'update')->name('manage.staff.update');
       Route::post('/manage-staff/delete/{id}', 'destroy')->name('manage.staff.delete');
       Route::get('/all-area-manager', 'showAllAreaManagers')->name('all.area.manager'); 
       Route::get('/all-counter-manager', 'showAllCounterManagers')->name('all.counter.manager'); 
       Route::get('/all-driver', 'showAllDrivers')->name('all.driver'); 
    });

    // counter routes

    Route::controller(CounterController::class)->group(function () {

        Route::get('/counters', 'index')->name('counter.index');
        Route::get('/counter/create', 'create')->name('counter.create');
        Route::post('/counter/store', 'store')->name('counter.store');
        Route::get('/counter/edit/{id}', 'edit')->name('counter.edit');
        Route::post('/counter/update/{id}', 'update')->name('counter.update');
        Route::get('/counter/delete/{id}', 'destroy')->name('counter.delete');
    });

    // vehicle type management routes

    Route::controller(VehicleTypeController::class)->group(function () {

        Route::get('/vehicle/types', 'index')->name('vehicle.type.index');
        Route::post('/vehicle/type/store', 'store')->name('vehicle.type.store');
        Route::get('/vehicle/type/edit/{id}', 'edit')->name('vehicle.type.edit');
        Route::post('/vehicle/type/update/{id}', 'update')->name('vehicle.type.update');
        Route::get('/vehicle/type/delete/{id}', 'destroy')->name('vehicle.type.delete');
    });

    // vehicle management routes

    Route::controller(VehicleController::class)->group(function () {

        Route::get('/vehicle/index', 'index')->name('vehicle.index');
        Route::post('/vehicle/store', 'store')->name('vehicle.store');
        Route::get('/vehicle/edit/{id}', 'edit')->name('vehicle.edit');
        Route::post('/vehicle/update/{id}', 'update')->name('vehicle.update');
        Route::get('/vehicle/delete/{id}', 'destroy')->name('vehicle.delete');
    });

    /*
     * 
     * Manage Trips routes
     *
     */

     // vehicle routes manage
     
    Route::controller(TripsRouteController::class)->group(function () {

        Route::get('/trips/route/index', 'index')->name('trips.route.index');
        Route::get('/trips/route/create', 'create')->name('trips.route.create');
        Route::post('/trips/route/store', 'store')->name('trips.route.store');
        Route::get('/trips/route/edit/{id}', 'edit')->name('trips.route.edit');
        Route::post('/trips/route/update/{id}', 'update')->name('trips.route.update');
        Route::get('/trips/route/delete/{id}', 'destroy')->name('trips.route.delete');
    });

    // ticket routes

    Route::controller(TicketPriceController::class)->group(function () {

        Route::get('/ticket/index', 'index')->name('ticket.index');
        Route::get('/ticket/create', 'create')->name('ticket.create');
        Route::post('/ticket/store', 'store')->name('ticket.store');
        Route::get('/ticket/edit/{id}', 'edit')->name('ticket.edit');
        Route::post('/ticket/update/{id}', 'update')->name('ticket.update');
        Route::get('/ticket/delete/{id}', 'destroy')->name('ticket.delete');
    });

});


