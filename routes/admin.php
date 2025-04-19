<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\patientController;
use App\Http\Controllers\user\profileController;
use App\Http\Controllers\admin\AdminHomeController;
use App\Http\Controllers\admin\auth\AdminLoginController;
use App\Http\Controllers\admin\auth\AdminRegisterController;

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

Route::get('admin/dashboard/login', [AdminLoginController::class, 'login'])->name('admin.dashboard.login');

Route::post('admin/dashboard/login', [AdminLoginController::class, 'checkLogin'])->name('admin.dashboard.check');

Route::get('admin/dashboard/register', [AdminRegisterController::class, 'register'])->name('admin.dashboard.register');

Route::post('admin/dashboard/register', [AdminRegisterController::class, 'store'])->name('admin.dashboard.store');

Route::get('admin/dashboard/home', [AdminHomeController::class, 'index'])->name('admin.dashboard.home')->middleware('auth:admin');

Route::post('admin/dashboard/logout', [AdminLoginController::class, 'logout'])->name('admin.dashboard.logout');

Route::get('admin/dashboard/home', [AdminHomeController::class, 'showUsers'])->name('admin.dashboard.home')->middleware('auth:admin');
