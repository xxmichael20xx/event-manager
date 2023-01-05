<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\HomeController;
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
Auth::routes();

// Define homepage
Route::get('/', [GuestController::class, 'welcome'])->name('/');

// Define /home page
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Define /book-now page
Route::get('/book-now', [HomeController::class, 'bookNow'])->name('book-now');

// Define booking functions
Route::post('/booking/add', [BookingController::class, 'bokkingAdd'])->name('booking.add');

// Define a group of web routes for admin
// with a prefix of "admin"
// i.e. https://domain.com/admin/
Route::group([ 'prefix' => 'admin', 'middleware' => 'system.admin' ], function() {
    // Define dashboard page
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Define occasions page
    Route::get('occasions', [AdminController::class, 'occasions'])->name('admin.occasions');
});