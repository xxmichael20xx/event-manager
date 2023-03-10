<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Define auth routes (login, register, forgot password)
Auth::routes([ 'verify' => true ]);

// Define homepage
Route::get('/', [GuestController::class, 'welcome'])->name('/');

// Define /home page
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Define /book-now page
Route::get('/book-now', [HomeController::class, 'bookNow'])->name('book-now');

// Define /events page
Route::get('/events', [HomeController::class, 'events'])->name('events');

// Define /my-account page
Route::get('/my-account', [HomeController::class, 'myAccount'])->name('my-account');

// Define profile update
Route::post('/profile-update', [HomeController::class, 'profileUpdate'])->name('profile-update');

// Define booking functions
Route::post('/booking/add', [BookingController::class, 'bookingAdd'])->name('booking.add');

// Define route to fetch available schedules
Route::post('/available-schedules', [BookingController::class, 'availableSchedules'])->name('available.schedules');

// Define a group of web routes for admin
// with a prefix of "admin"
// i.e. https://domain.com/admin/
Route::group([ 'prefix' => 'admin', 'middleware' => 'system.admin' ], function() {
    // Define dashboard page
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Define events page
    Route::get('events', [AdminController::class, 'events'])->name('admin.events');
    
    // Define single event page
    Route::get('/events/{id}', [AdminController::class, 'eventsShow'])->name('admin.events.show');

    // Define admin add event
    Route::post('/event/add', [AdminController::class, 'addEvent'])->name('admin.booking.add');

    // Define admin delete event
    Route::post('/event/delete/{id}', [AdminController::class, 'deleteEvent'])->name('admin.booking.delete');

    // Define admin done event
    Route::post('/event/done/{id}', [AdminController::class, 'doneEvent'])->name('admin.booking.done');

    // Define admin update event
    Route::post('/event/update/{id}', [AdminController::class, 'updateEvent'])->name('admin.booking.update');

    // Define admin event payment route
    Route::post('/event/payment/{id}', [AdminController::class, 'eventPayment'])->name('admin.event.payment');

    // Define admin actvity logs page
    Route::get('/activity/logs', [AdminController::class, 'activityLogs'])->name('admin.activity.logs');

    // Define admin users page
    Route::get('/users', [AdminController::class, 'adminUsers'])->name('admin.users' );

    // Define admin user show page
    Route::get('/users/{id}', [AdminController::class, 'adminUsersShow'])->name('admin.users.show' );

    // Define admin user activate
    Route::post('/users/activate/{id}', [AdminController::class, 'adminUsersActivate'])->name('admin.users.activate' );

    // Define admin user deactivate
    Route::post('/users/deactivate/{id}', [AdminController::class, 'adminUsersDeactivate'])->name('admin.users.deactivate' );

    // Define venue page
    Route::get('/venue', [AdminController::class, 'venues'])->name('admin.venues');

    // Define add venue route
    Route::post('/venue/add', [AdminController::class, 'venueAdd'])->name('admin.venue.add');

    // Define update venue route
    Route::post('/venue/update/{id}', [AdminController::class, 'venueUpdate'])->name('admin.venue.update');

    // Define show venue page
    Route::get('/venue/show/{id}', [AdminController::class, 'venueShow'])->name('admin.venue.show');

    // Define delete venue route
    Route::post('/venue/delete/{id}', [AdminController::class, 'venueDelete'])->name('admin.venue.delete');

    // Define restore venue route
    Route::post('/venue/restore/{id}', [AdminController::class, 'venueRestore'])->name('admin.venue.restore');
});