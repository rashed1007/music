<?php

use App\Http\Controllers\Api\AlbumController;
use App\Http\Controllers\Api\ArtistController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SongController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::prefix('auth')->group(function () {
    // OTP
    Route::post('send-otp',   [AuthController::class, 'sendOtp']);
    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);

    // Register
    Route::post('register', [AuthController::class, 'register']);

    // Logout (protected)
    Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
});





Route::middleware('auth:sanctum')->prefix('artist')->group(function () {
    Route::get('/', [ArtistController::class, 'index'])->name('artist.index');
    Route::post('/', [ArtistController::class, 'store'])->name('artist.store');
    Route::get('/{uuid}', [ArtistController::class, 'show'])->name('artist.show');
    Route::put('/{uuid}', [ArtistController::class, 'update'])->name('artist.update');
    Route::delete('/{uuid}', [ArtistController::class, 'destroy'])->name('artist.destroy');
});



Route::middleware('auth:sanctum')->prefix('album')->group(function () {
    Route::get('/', [AlbumController::class, 'index'])->name('album.index');
    Route::post('/', [AlbumController::class, 'store'])->name('album.store');
    Route::get('/{uuid}', [AlbumController::class, 'show'])->name('album.show');
    Route::put('/{uuid}', [AlbumController::class, 'update'])->name('album.update');
    Route::delete('/{uuid}', [AlbumController::class, 'destroy'])->name('album.destroy');
});




Route::middleware('auth:sanctum')->prefix('song')->group(function () {
    Route::get('/', [SongController::class, 'index'])->name('song.index');
    Route::post('/', [SongController::class, 'store'])->name('song.store');
    Route::get('/{uuid}', [SongController::class, 'show'])->name('song.show');
    Route::put('/{uuid}', [SongController::class, 'update'])->name('song.update');
    Route::delete('/{uuid}', [SongController::class, 'destroy'])->name('song.destroy');
});
