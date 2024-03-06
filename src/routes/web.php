<?php

use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
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
    Route::get('/mypage', [UserController::class, 'index'])->name('mypage');
    Route::post('/reservation', [UserController::class, 'storeReservation']);
    Route::delete('/reservation/delete', [UserController::class, 'destroyReservation']);
    Route::post('/favorite', [UserController::class, 'storeFavorite']);
    Route::delete('/favorite/delete', [UserController::class, 'destroyFavorite']);
    Route::get('/done', [UserController::class, 'showDone']);
    Route::post('/favorite', [UserController::class, 'storeFavorite']);
});

Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/detail/{shop_id}', [ShopController::class, 'showDetail']);
Route::get('/back', [ShopController::class, 'back']);
Route::get('/thanks', [RegisterController::class, 'showThanks']);



