<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\LogoutController;
use App\Http\Controllers\API\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LogoutController::class, '__invoke']);

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'CheckRole:superadmin'])->group(function () {

    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [App\Http\Controllers\API\DashboardController::class, 'dashboard']);
    });

    Route::group(['prefix' => 'products'], function () {
        Route::get('/', [App\Http\Controllers\API\ProductController::class, 'index']);
        Route::post('/', [App\Http\Controllers\API\ProductController::class, 'store']);
        Route::get('/{id}', [App\Http\Controllers\API\ProductController::class, 'show']);
        Route::put('/{id}', [App\Http\Controllers\API\ProductController::class, 'update']);
        Route::delete('/{id}', [App\Http\Controllers\API\ProductController::class, 'destroy']);
    });

    Route::group(['prefix' => 'customers'], function () {
        Route::get('/', [App\Http\Controllers\API\CustomerController::class, 'index']);
        Route::post('/', [App\Http\Controllers\API\CustomerController::class, 'store']);
        Route::get('/{id}', [App\Http\Controllers\API\CustomerController::class, 'show']);
        Route::put('/{id}', [App\Http\Controllers\API\CustomerController::class, 'update']);
        Route::delete('/{id}', [App\Http\Controllers\API\CustomerController::class, 'destroy']);
    });

    Route::group(['prefix' => 'transactions'], function () {
        Route::get('/', [App\Http\Controllers\API\TransactionController::class, 'index']);
        Route::get('/{transaction}/print', [App\Http\Controllers\API\TransactionController::class, 'print']);
        Route::post('/', [App\Http\Controllers\API\TransactionController::class, 'store']);
        Route::get('/{transaction}', [App\Http\Controllers\API\TransactionController::class, 'show']);
        Route::put('/{transaction}', [App\Http\Controllers\API\TransactionController::class, 'update']);
        Route::delete('/{transaction}', [App\Http\Controllers\API\TransactionController::class, 'destroy']);
    });

    Route::group(['prefix' => 'reports'], function () {
        Route::get('/monthly', [App\Http\Controllers\API\ReportController::class, 'monthlyReport']);
        Route::get('/products', [App\Http\Controllers\API\ReportController::class, 'productReport']);
    });

});