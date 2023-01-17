<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
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

Route::get('account', [AuthenticatedSessionController::class, 'accountShow']);

Route::post('account', [AuthenticatedSessionController::class, 'accountWrite']);
// ++++++++++ authentication

// ++++++++++ main

Route::get('', function () {
    return Inertia::render('Home');
})->middleware(['auth'])->name('home');

// ++++++++++ main

// ++++++++++ Users
Route::get("users", [UserController::class, "index"]);

Route::get("user/create", [UserController::class, "create"]);

Route::get("user/edit/{user}", [UserController::class, "edit"]);

Route::post("user/write", [UserController::class, "write"]);

Route::delete("user/{user}", [UserController::class, "delete"]);

Route::get("user/{user}/deleteImage", [UserController::class, "deleteImage"]);

Route::get("user/updateStatus/{user}", [UserController::class, "updateStatus"]);

Route::get('users/export/excel', [UserController::class, 'exportExcel']);

Route::get('user/permissions/{user}', [UserController::class, 'showPermissions']);

Route::post('user/permissions/{user}', [UserController::class, 'updatePermissions']);


// ++++++++++ Users

// +++++++++++++++++ employees

Route::get("employees", [EmployeeController::class, "index"]);

Route::get("employee/create", [EmployeeController::class, "create"]);

Route::get("employee/edit/{employee}", [EmployeeController::class, "edit"]);

Route::post("employee/write", [EmployeeController::class, "write"]);

Route::delete("employee/{user}", [EmployeeController::class, "delete"]);

Route::get("employee/{employee}/deleteImage", [EmployeeController::class, "deleteImage"]);

Route::get('employees/export/excel', [EmployeeController::class, 'exportExcel']);

// +++++++++++++++++ employees

// +++++++++++++++++ expenses

Route::get("expenses", [ExpenseController::class, "index"]);

// Route::get("expenses/getData", [ExpenseController::class, "getData"]);

// Route::post("expense/write", [ExpenseController::class, "write"]);

// Route::delete("expense/{user}", [ExpenseController::class, "delete"]);

// Route::get('expenses/export/excel/{employee}', [ExpenseController::class, 'exportExcel']);

// +++++++++++++++++ expenses

// +++++++++++++++++ deductions

Route::get("deductions", [DeductionController::class, "index"]);

// Route::get("deductions/getData", [DeductionController::class, "getData"]);

// Route::post("deduction/write", [DeductionController::class, "write"]);

// Route::delete("deduction/{user}", [DeductionController::class, "delete"]);

// Route::get('deductions/export/excel/{employee}', [DeductionController::class, 'exportExcel']);

// +++++++++++++++++ deductions

// +++++++++++++++++ reports

Route::get('reports', [ReportController::class, 'index']);
Route::get('charts', [ReportController::class, 'showCharts']);

// Route::get("reports/getData", [ReportController::class, "getData"]);

// Route::post('export/pdf', [ReportController::class, 'exportPdf']);

// Route::post('export/excel', [ReportController::class, 'exportExcel']);

// Route::get('charts', [ReportController::class, 'charts']);

// +++++++++++++++++ deductions

Route::any('{query}',
    function () {return inertia('Errors/404');})
    ->where('query', '.*');
