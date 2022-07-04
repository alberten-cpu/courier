<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
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
    return redirect('auth/login');
});

Route::post('auth.save',[AuthController::class,'save'])->name('auth.save');
Route::post('auth.check',[AuthController::class,'check'])->name('auth.check');
Route::get('admin',[AuthController::class,'login']);
Route::get('/auth/logout',[AuthController::class, 'logout'])->name('auth.logout');


Route::group(['middleware'=>['Authcheck']], function(){

    Route::get('auth/login',[AuthController::class,'login'])->name('auth.login');
    Route::get('auth/register',[AuthController::class,'register'])->name('auth.register');
    Route::get('admin/dashboard',[AuthController::class,'dashboard'])->name('admin.dashboard');
    Route::get('admin/newuser',[AdminController::class,'createnew'])->name('admin.newuser');

    //  driver
    Route::get('admin/adddriver',[AdminController::class,'adddriver'])->name('admin.adddriver');
    Route::post('admin.adddriverdb',[AdminController::class,'adddriverdb'])->name('admin.adddriverdb');
    Route::get('admin/viewdriver',[AdminController::class,'viewdriver'])->name('admin.viewdriver');
    // area
    Route::get('admin/addarea',[AdminController::class,'addarea'])->name('admin.addarea');
    Route::post('admin/addareadb',[AdminController::class,'addareadb'])->name('admin.addareadb');

});

