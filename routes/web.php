<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\User\CustomerController;
use App\Http\Controllers\Admin\User\DriverController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes(['verify' => true]);

Route::get('/', function () {
    return redirect('login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*Admin Routes */
    Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'name' => 'admin' . '.'], function () {
        Route::resource('/user/customer', CustomerController::class)->name('*', 'customer');
        Route::resource('/user/driver', DriverController::class)->name('*', 'driver');
    });

    /*Customer Routes */
    Route::group(['middleware' => 'customer', 'prefix' => 'customer', 'name' => 'customer' . '.'], function () {
        /*routes here*/
    });

    /*Driver Routes */
    Route::group(['middleware' => 'driver', 'prefix' => 'driver', 'name' => 'driver' . '.'], function () {
        /*routes here*/
    });
});
