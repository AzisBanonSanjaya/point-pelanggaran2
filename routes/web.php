<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserManagement\PermissionController;
use App\Http\Controllers\UserManagement\ProfileController;
use App\Http\Controllers\UserManagement\RoleController;
use App\Http\Controllers\UserManagement\UserController;
use App\Http\Controllers\dataMaster\KelasController;

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

Route::get('/', [LoginController::class, 'index'])->name("login");
Route::post('/', [LoginController::class, 'authenticate'])->name("authenticate");
Route::get('/forgot-password', [LoginController::class, 'forgotPassword'])->name("forgot.password");
Route::post('/forgot-password', [LoginController::class, 'sendForgotPassword'])->name("send.forgot.password");
Route::get('/password_reset', [LoginController::class, 'resetPassword'])->name("password.reset");
Route::post('/password_reset', [LoginController::class, 'submitResetPassword'])->name("submit.password.reset");
Route::post('/logout', [LoginController::class, 'logout'])->name("logout");

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name("dashboard");

    Route::resource('profile', ProfileController::class)->except(['create','edit', 'destroy','update']);
    
    Route::group(['prefix' => 'user_management'], function(){
        Route::resource('user', UserController::class)->except(['create','edit']);
        Route::resource('role', RoleController::class)->except(['create','edit','index','update']);
        Route::resource('permission', PermissionController::class)->except(['create','edit','index','update']);
        Route::get('profile', [ProfileController::class, 'index'])->name("profile.index");
        Route::post('profile', [ProfileController::class, 'store'])->name("profile.store");
        Route::get('user-struktur', [UserController::class, 'getStruktur'])->name("user.getStruktur");
    });

    Route::group(['prefix' => 'datatable'], function(){
        Route::group(['prefix' => 'user_management'], function(){
            Route::get('user', [UserController::class, 'fetchDataTable'])->name('user.fetchDataTable');
        });
    });

    Route::prefix('master_data')->group(function () {
        Route::resource('kelas', KelasController::class);
    });
});
