<?php

use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\User\CustomerController;
use App\Http\Controllers\Admin\User\DriverController;
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
        Route::get('/list_customer', [CustomerController::class, 'getCustomers'])->name('customer.list');
        Route::resource('/user/driver', DriverController::class)->name('*', 'driver');
        Route::resource('/area', AreaController::class)->name('*', 'area');
        Route::get('/list_area', [AreaController::class, 'getAreas'])->name('area.list');
        Route::resource('/job', JobController::class)->name('*', 'job');
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
