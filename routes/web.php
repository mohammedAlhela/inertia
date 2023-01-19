<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Main\CompanyController;



use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('reset-password/{token}', [PasswordResetController::class, 'update'])
    ->name('password.reset');

Route::post('reset-password', [PasswordResetController::class, 'reset'])
    ->name('password-update');

// ++++++++++ password reset

// ++++++++++ email verification

Route::get('email/verify', [EmailVerificationController::class, 'create'])->name('verification.notice');

Route::post('email/verification-notification', [EmailVerificationController::class, 'send'])->name('verification.send');

Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');

// ++++++++++ email verification

// ++++++++++ password confirmation
Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])
    ->name('password.confirm');

Route::post('password/confirm', [ConfirmPasswordController::class, 'confirmPassword'])
    ->name('password.confirm.send')
    ->middleware('auth');

// ++++++++++ password confirmation

// ++++++++++ authentication
Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store');

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::get('account', [AccountController::class, 'index']);

Route::post('account', [AccountController::class, 'update']);

Route::post('account/password', [AccountController::class, 'updatePassword']);
// ++++++++++ authentication

// ++++++++++ main




Route::get('company' , [CompanyController::class , 'index'])->name('company.index');
Route::post('company/{company}' , [CompanyController::class , 'update'])->name('company.update');

Route::get('', function () {
    return Inertia::render('Home');
})->middleware(['auth'])->name('home');

// ++++++++++ main

Route::any('{query}',
    function () {return inertia('Errors/404');})
    ->where('query', '.*');
