<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
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

Route::group(['prefix' => 'customers', 'as' => 'customer.'], function () {
    Route::get('/', [CustomerController::class, 'index'])->name('list');
    Route::post('/', [CustomerController::class, 'store'])->name('store');
});

Route::group(['prefix' => 'transactions', 'as' => 'transaction.'], function () {
    Route::get('/', [TransactionController::class, 'index'])->name('list');
    Route::post('/', [TransactionController::class, 'store'])->name('store');
});
