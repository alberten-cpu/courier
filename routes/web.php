<?php

use App\Http\Controllers\Admin\User\CustomerController;
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

Route::get('/', function () {
    return redirect('login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user/customer', CustomerController::class)->name('*', 'customer');
});
Route::post('auth.save', [AuthController::class, 'save'])->name('auth.save');
Route::post('auth.check', [AuthController::class, 'check'])->name('auth.check');
Route::get('admin', [AuthController::class, 'login']);
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('admin/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');
Route::get('admin/newuser', [AdminController::class, 'createnew'])->name('admin.newuser');

//  driver
Route::get('admin/adddriver', [AdminController::class, 'adddriver'])->name('admin.adddriver');
Route::post('admin.adddriverdb', [AdminController::class, 'adddriverdb'])->name('admin.adddriverdb');
Route::get('admin/viewdriver', [AdminController::class, 'viewdriver'])->name('admin.viewdriver');
// area
Route::get('admin/addarea', [AdminController::class, 'addarea'])->name('admin.addarea');
Route::post('admin/addareadb', [AdminController::class, 'addareadb'])->name('admin.addareadb');


Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
