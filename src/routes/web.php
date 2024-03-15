<?php

use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController;
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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/reservation', [ReservationController::class, 'store']);
    Route::delete('/reservation/delete', [ReservationController::class, 'destroy']);
    Route::get('/reservation/update', [ReservationController::class, 'showChange']);
    Route::patch('/reservation/update', [ReservationController::class, 'update']);
    Route::get('/done', [ReservationController::class, 'showDone']);

    Route::get('/mypage', [UserController::class, 'index'])->name('mypage');
    Route::post('/favorite', [UserController::class, 'store']);
    Route::delete('/favorite/delete', [UserController::class, 'destroy']);

    Route::POST('/detail/{shop_id}/evaluation', [ShopController::class, 'store']);
});

Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/detail/{shop_id}', [ShopController::class, 'show']);
Route::get('/back', [ShopController::class, 'back']);

Route::get('/admin/login', [AdminController::class, 'create']);
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::middleware('auth.admins:admins')->group(function() {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::post('/admin', [AdminController::class, 'store']);
    Route::post('/admin/logout', [AdminController::class, 'logout']);
    Route::get('/admin/mail', [AdminController::class, 'showMail']);
    Route::post('/admin/mail', [AdminController::class, 'send']);
});

Route::middleware('auth.owners:owners')->group(function () {
    Route::get('/owner', [OwnerController::class, 'index']);
    Route::post('/owner', [OwnerController::class, 'store']);
    Route::patch('/owner/update', [OwnerController::class, 'update']);
    Route::post('/owner/logout', [OwnerController::class, 'logout']);
});
Route::get('/owner/login', [OwnerController::class, 'create']);
Route::post('/owner/login', [OwnerController::class, 'login'])->name('owner.login');

Route::get('/thanks', [RegisterController::class, 'showThanks']);
Route::get('/register/verify', [RegisterController::class, 'showVerify'])->middleware('auth')->name('verification.notice');
Route::get('/register/verify/{id}/{hash}', [RegisterController::class, 'confirm'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/register/verify/send', [RegisterController::class, 'send'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');



