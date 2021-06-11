<?php

use App\Domain\Auth\Http\Controllers\LoginController;
use App\Domain\Auth\Http\Controllers\RegisterController;
use App\Domain\Product\Http\Controllers\ProductController;
use App\Domain\Transaction\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('register', [RegisterController::class, 'register'])->name('register');  
    Route::post('login', [LoginController::class, 'login'])->name('login');  

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');  
        Route::get('me', [LoginController::class, 'me'])->name('me'); 
    });
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('product', [ProductController::class, 'listAll']);
});