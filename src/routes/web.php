<?php

use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\EvaluationController;
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

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/detail/{shop_id}', [ShopController::class, 'show']);
Route::get('/back', [ShopController::class, 'back']);

Route::get('/thanks', [RegisterController::class, 'showThanks']);
Route::get('/register/verify', [RegisterController::class, 'showVerify'])->middleware('auth:web,owners')->name('verification.notice');
Route::get('/register/verify/{id}/{hash}', [RegisterController::class, 'confirm'])->middleware(['auth:web,owners', 'signed'])->name('verification.verify');
Route::post('/register/verify/send', [RegisterController::class, 'send'])->middleware(['auth:web,owners', 'throttle:6,1'])->name('verification.send');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/reservation/{shop}', [ReservationController::class, 'store']);
    Route::delete('/reservation/delete/{reservation}', [ReservationController::class, 'destroy']);
    Route::get('/reservation/update/{reservation}', [ReservationController::class, 'showUpdate']);
    Route::patch('/reservation/update/{reservation}', [ReservationController::class, 'update']);
    Route::get('/reservation/payment/{reservation}', [ReservationController::class, 'create']);
    Route::get('/reservation/payment/{reservation}/success', [ReservationController::class, 'success'])->name('success');
    Route::get('/done', [ReservationController::class, 'showDone'])->name('cancel');
    Route::get('/mypage', [UserController::class, 'index'])->name('mypage');
    Route::post('/favorite/{shop}', [UserController::class, 'store']);
    Route::delete('/favorite/{shop}/delete', [UserController::class, 'destroy']);
    Route::post('/detail/evaluation/{shop_id}', [EvaluationController::class, 'store']);
    Route::get('/detail/evaluation/{shop_id}', [EvaluationController::class, 'show']);
    Route::patch('/detail/evaluation/{shop_id}/{evaluation_id}', [EvaluationController::class, 'update']);
});

Route::middleware('user_or_admin')->group(function () {
    Route::delete('/detail/evaluation/delete/{evaluation_id}', [EvaluationController::class, 'destroy']);
});

Route::middleware('auth:admins')->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::post('/admin', [AdminController::class, 'store']);
    Route::get('/admin/import', [AdminController::class, 'create']);
    Route::post('/admin/import', [AdminController::class, 'storeShop']);
    Route::get('/admin/mail', [AdminController::class, 'showMail']);
    Route::post('/admin/mail', [AdminController::class, 'send']);
});

Route::middleware(['auth:owners', 'verified'])->group(function () {
    Route::get('/owner', [OwnerController::class, 'index']);
    Route::post('/owner', [OwnerController::class, 'store']);
    Route::patch('/owner/update/{shop}', [OwnerController::class, 'update']);
});
