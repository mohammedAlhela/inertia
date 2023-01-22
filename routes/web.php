<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Main\CompanyController;
use App\Http\Controllers\Users\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
 */

// ++++++++++ password reset

Route::get('forgot-password', [PasswordResetController::class, 'create'])
    ->name('password.request');

Route::post('forgot-password', [PasswordResetController::class, 'store'])
    ->name('password.email');

Route::get('password-reset/{token}/{email}', [PasswordResetController::class, 'update'])
    ->name('password.reset');

Route::post('password-reset', [PasswordResetController::class, 'reset'])
    ->name('password.update');

// ++++++++++ password reset


// ++++++++++ authentication
Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store');

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::get('account', [AccountController::class, 'index']);

Route::post('account', [AccountController::class, 'update']);

Route::post('account/credentials', [AccountController::class, 'updateCredentials']);
// ++++++++++ authentication

// ++++++++++ main
Route::get('company' , [CompanyController::class , 'index']);
Route::post('company/{company}' , [CompanyController::class , 'update']);
Route::get('company/export/pdf' , [CompanyController::class , 'exportPdf']);

Route::get('', function () {
    return inertia('App/Home');
})->middleware(['auth']);
// ++++++++++ main


// ++++++++++ admins
Route::get('admins' , [AdminController::class , 'index']);
Route::get('admin/create' , [AdminController::class , 'create']);
Route::post('admin/store' , [AdminController::class , 'store']);
Route::get('admin/edit/{admin}' , [AdminController::class , 'edit']);
Route::post('admin/update/{admin}' , [AdminController::class , 'update']);
Route::delete('admins/{admins}' , [AdminController::class , 'delete']);
Route::get('admin/permissions/{admin}' , [AdminController::class , 'ShowPermissions']);
Route::post('admin/permissions/{admin}' , [AdminController::class , 'UpdatePermissions']);
Route::get('admin/credentials/{admin}' , [AdminController::class , 'ShowCredentials']);
Route::post('admin/credentials/{admin}' , [AdminController::class , 'UpdateCredentials']);
Route::get('admins/block/{admins}' , [AdminController::class , 'block']);
Route::get('admins/unblock/{admins}' , [AdminController::class , 'unblock']);
Route::get('admins/export/excel/{admins}' , [AdminController::class , 'exportExcel']);
Route::get('admins/export/pdf/{admins}' , [AdminController::class , 'exportPdf']);
Route::post('admins/sendEmailMessage/{admins}' , [AdminController::class , 'emailMessage']);
Route::post('admins/send' , [AdminController::class , 'send']);

// send notification message
// Invito to login using email message 
// Invito to login using email message 
// ++++++++++ admins


Route::any('{query}',
    function () {return inertia('App/Errors/404');})
    ->where('query', '.*');
