<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


use App\Http\Controllers\AuthFormController;


Route::get('/login', [AuthFormController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthFormController::class, 'showRegisterForm'])->name('register');
Route::get('/logout', [AuthFormController::class, 'logout'])->name('logout');

Route::post('/web-login', [AuthFormController::class, 'login'])->name('web.login');
Route::post('/web-register', [AuthFormController::class, 'register'])->name('web.register');

use App\Http\Controllers\BookingController;

Route::get('/', [BookingController::class, 'index'])->name('seats_view.index');
// Route::get('/', [BookingController::class, 'index']);
Route::post('/book', [BookingController::class, 'book'])->name('seats.book');
Route::get('/booked-seats', [BookingController::class, 'bookedSeats'])->name('seats.booked');



use App\Http\Controllers\BusViewController;


Route::get('/buses_view', [BusViewController::class, 'index'])->name('buses_view.index');
Route::get('/buses_view/{id}', [BusViewController::class, 'show'])->name('buses_view.show');


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManageBookingController;
use App\Http\Controllers\SeatController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/verify/{ticket_number}', [BookingController::class, 'verify'])->name('tickets.verify');


Route::resource('buses', \App\Http\Controllers\BusController::class);



Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('bookings', [ManageBookingController::class, 'index'])->name('manage-bookings.index');
    Route::get('bookings/{booking}', [ManageBookingController::class, 'show'])->name('manage-bookings.show');
    Route::delete('bookings/{booking}', [ManageBookingController::class, 'destroy'])->name('manage-bookings.destroy');
    Route::patch('bookings/{booking}/status', [ManageBookingController::class, 'updateStatus'])->name('manage-bookings.status');
});


Route::resource('seats', SeatController::class);
