<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\GiftResultController;
use App\Http\Controllers\MemberController;
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

Route::prefix('mastermember')->group(function () {
    Route::get('/', [MemberController::class, 'index'])->name('members.index');
    Route::post('/', [MemberController::class, 'store'])->name('members.store');
    Route::get('/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
    Route::post('/{member}', [MemberController::class, 'update'])->name('members.update');
    Route::delete('/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
});

Route::prefix('masterevent')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('events.index');
    Route::post('/', [EventController::class, 'store'])->name('events.store');
    Route::get('/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::post('/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/{event}', [EventController::class, 'destroy'])->name('events.destroy');
});


Route::prefix('mastergift')->group(function () {
    Route::get('/', [GiftController::class, 'index'])->name('gifts.index');
    Route::post('/', [GiftController::class, 'store'])->name('gifts.store');
    Route::get('/{gift}/edit', [GiftController::class, 'edit'])->name('gifts.edit');
    Route::post('/{gift}', [GiftController::class, 'update'])->name('gifts.update');
    Route::delete('/{gift}', [GiftController::class, 'destroy'])->name('gifts.destroy');
});

Route::prefix('mastergiftresult')->group(function () {
    Route::get('/', [GiftResultController::class, 'index'])->name('giftresults.index');
    Route::post('/', [GiftResultController::class, 'store'])->name('giftresults.store');
    Route::get('/{gift}results/edit', [GiftResultController::class, 'edit'])->name('giftresults.edit');
    Route::post('/{giftresults}', [GiftResultController::class, 'update'])->name('giftresults.update');
    Route::delete('/{giftresults}', [GiftResultController::class, 'destroy'])->name('giftresults.destroy');
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


