<?php

use App\Http\Controllers\NavController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MeetingController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']); // ✅ must be POST
//Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('signup', [AuthController::class, 'signup']);

// Protected routes
Route::middleware(['custom.auth'])->group(function () {

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
});

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/admin/profile', [AdminController::class, 'showProfile'])
    ->name('admin.profile')
    ->middleware(['auth', 'role:admin']);

Route::get('/guest/profile', [AdminController::class, 'showProfile'])
    ->name('guest.profile')
    ->middleware(['auth', 'role:guest']);

Route::get('/employee/profile', [AdminController::class, 'showProfile'])
    ->name('employee.profile')
    ->middleware(['auth', 'role:employee']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

Route::delete('/cancel-booking/{booking}', [BookController::class, 'cancelBooking'])->name('employee.cancelBooking');

Route::post('/employee/book/{room}', [BookController::class, 'bookRoom'])->name('employee.bookRoom');

Route::put('/admin/update-profile', [AdminController::class, 'updateProfile'])->name('admin.updateProfile');
Route::put('/employee/update-profile', [AdminController::class, 'updateProfile'])->name('employee.updateProfile');
Route::put('/employee/bookings/{booking}/reschedule', [BookController::class, 'rescheduleBooking'])->name('employee.rescheduleBooking');

Route::post('/employee/meetings/{booking}', [MeetingController::class, 'store'])
    ->name('meetings.store');

Route::post('/bookings/{booking}/schedule-meeting', [MeetingController::class, 'store'])->name('employee.scheduleMeeting');

Route::post('/meetings/{meeting}/invite-guests', [MeetingController::class, 'inviteGuests'])->name('meetings.inviteGuests');

Route::delete('/meetings/{meeting}', [MeetingController::class, 'deleteMeeting'])
    ->name('meetings.delete')
    ->middleware('auth');





