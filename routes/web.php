<?php

use App\Http\Controllers\EventController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// auth

Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
});
Route::get('/forgot-password', function () {
    return view('auth.forgotpassword');
});

//error
Route::get('/404', function () {
    return view('pages.404');
});
Route::get('/blank', function () {
    return view('pages.blank');
});

//utilities
Route::get('/', function () {
    return view('pages.dashboard');
});
Route::get('/mastermember', function () {
    return view('pages.mastermember');
});

Route::prefix('masterevent')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('events.index');
    Route::post('/', [EventController::class, 'store'])->name('events.store');
    Route::get('/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::post('/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/{event}', [EventController::class, 'destroy'])->name('events.destroy');
});

Route::get('/mastergift', function () {
    return view('pages.mastergift');
});
Route::get('/mastergiftresult', function () {
    return view('pages.mastergiftresult');
});
Route::get('/import', function () {
    return view('pages.import');
});

Route::get('/MainLottery', function () {
    return view('pages.MainLottery');
});
Route::get('/RegularLottery', function () {
    return view('pages.RegularLottery');
});

// routing management


