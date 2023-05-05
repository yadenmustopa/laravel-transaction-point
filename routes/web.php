<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Home', ['data' => ["cek"]]);
});

Route::group(['prefix' => 'customers', 'as' => 'customer.'], function () {
    Route::get('/', [CustomerController::class, 'index'])->name('list');
    Route::post('/', [CustomerController::class, 'store'])->name('store');
});

Route::group(['prefix' => 'transactions', 'as' => 'transaction.'], function () {
    Route::get('/', [TransactionController::class, 'index'])->name('list');
    Route::post('/', [TransactionController::class, 'store'])->name('store');
});