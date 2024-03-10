<?php

use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReservationController;
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

Route::middleware('auth')->group(function () {
    Route::post('/reservation', [ReservationController::class, 'store']);
    Route::delete('/reservation/delete', [ReservationController::class, 'destroy']);
    Route::get('/reservation/change', [ReservationController::class, 'showChange']);
    Route::patch('/reservation/change', [ReservationController::class, 'change']);
    Route::get('/done', [ReservationController::class, 'showDone']);

    Route::get('/mypage', [UserController::class, 'index'])->name('mypage');
    Route::post('/favorite', [UserController::class, 'store']);
    Route::delete('/favorite/delete', [UserController::class, 'destroy']);

    Route::POST('/detail/{shop_id}/evaluation', [ShopController::class, 'store']);
});

Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/detail/{shop_id}', [ShopController::class, 'show']);
Route::get('/back', [ShopController::class, 'back']);

Route::get('/thanks', [RegisterController::class, 'showThanks']);



