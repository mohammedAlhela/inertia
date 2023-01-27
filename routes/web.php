<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Main\CompanyController;
use App\Http\Controllers\Users\AdminController;
use App\Http\Controllers\Main\AcademicYearController;
use App\Http\Controllers\Main\AcademicTermController;
use App\Http\Controllers\Main\DepartmentController;
use App\Http\Controllers\Main\CourseController;
use App\Http\Controllers\Main\SectionController;
use App\Http\Controllers\Main\SubjectController;
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
    return inertia('App/Main/Home');
})->middleware('auth');
// ++++++++++ main


// ++++++++++ admins
Route::get('admins' , [AdminController::class , 'index']);
Route::get('admin/create' , [AdminController::class , 'create']);
Route::post('admin/store' , [AdminController::class , 'store']);
Route::get('admin/edit/{admin}' , [AdminController::class , 'edit']);
Route::post('admin/update/{admin}' , [AdminController::class , 'update']);
Route::delete('admins/{admins}' , [AdminController::class , 'delete']);
Route::get('admin/permissions/{admin}' , [AdminController::class , 'showPermissions']);
Route::post('admin/permissions/{admin}' , [AdminController::class , 'updatePermissions']);
Route::get('admin/credentials/{admin}' , [AdminController::class , 'showCredentials']);
Route::post('admin/credentials/{admin}' , [AdminController::class , 'updateCredentials']);
Route::get('admins/block/{admins}' , [AdminController::class , 'block']);
Route::get('admins/unBlock/{admins}' , [AdminController::class , 'unBlock']);
Route::get('admins/export/excel/{admins}' , [AdminController::class , 'exportExcel']);
Route::get('admins/export/pdf/{admins}' , [AdminController::class , 'exportPdf']);
Route::get('admins/emailMessage/{admins}' , [AdminController::class , 'showEmailMessage']);
Route::post('admins/emailMessage/{admins}' , [AdminController::class , 'sendEmailMessage']);
// send notification message
// Invito to login using email message 
// Invito to login using email message 
// ++++++++++ admins



// ++++++++++ academic years
Route::get('academicYears' , [AcademicYearController::class , 'index']);
Route::get('academicYear/create' , [AcademicYearController::class , 'create']);
Route::post('academicYear/store' , [AcademicYearController::class , 'store']);
Route::get('academicYear/edit/{academicYear}' , [AcademicYearController::class , 'edit']);
Route::post('academicYear/update/{academicYear}' , [AcademicYearController::class , 'update']);
Route::delete('academicYears/{academicYears}' , [AcademicYearController::class , 'delete']);
Route::get('academicYears/export/excel/{academicYears}' , [AcademicYearController::class , 'exportExcel']);
Route::get('academicYears/export/pdf/{academicYears}' , [AcademicYearController::class , 'exportPdf']);
// ++++++++++ academic years


// ++++++++++ academic terms
Route::get('academicTerms' , [AcademicTermController::class , 'index']);
Route::get('academicTerm/create' , [AcademicTermController::class , 'create']);
Route::post('academicTerm/store' , [AcademicTermController::class , 'store']);
Route::get('academicTerm/edit/{academicTerm}' , [AcademicTermController::class , 'edit']);
Route::post('academicTerm/update/{academicTerm}' , [AcademicTermController::class , 'update']);
Route::delete('academicTerms/{academicTerms}' , [AcademicTermController::class , 'delete']);
Route::get('academicTerms/export/excel/{academicTerms}' , [AcademicTermController::class , 'exportExcel']);
Route::get('academicTerms/export/pdf/{academicTerms}' , [AcademicTermController::class , 'exportPdf']);
// ++++++++++ academic terms



// ++++++++++ Departments 
Route::get('departments' , [DepartmentController::class , 'index']);
Route::get('department/create' , [DepartmentController::class , 'create']);
Route::post('department/store' , [DepartmentController::class , 'store']);
Route::get('department/edit/{department}' , [DepartmentController::class , 'edit']);
Route::post('department/update/{department}' , [DepartmentController::class , 'update']);
Route::delete('departments/{departments}' , [DepartmentController::class , 'delete']);
Route::get('departments/export/excel/{departments}' , [DepartmentController::class , 'exportExcel']);
Route::get('departments/export/pdf/{departments}' , [DepartmentController::class , 'exportPdf']);
// ++++++++++ Departments 



// ++++++++++ courses 
Route::get('courses' , [CourseController::class , 'index']);
Route::get('course/create' , [CourseController::class , 'create']);
Route::post('course/store' , [CourseController::class , 'store']);
Route::get('course/edit/{course}' , [CourseController::class , 'edit']);
Route::post('course/update/{course}' , [CourseController::class , 'update']);
Route::delete('courses/{courses}' , [CourseController::class , 'delete']);
Route::get('courses/export/excel/{courses}' , [CourseController::class , 'exportExcel']);
Route::get('courses/export/pdf/{courses}' , [CourseController::class , 'exportPdf']);
// ++++++++++ courses 




// ++++++++++ sections 
Route::get('sections' , [SectionController::class , 'index']);
Route::get('section/create' , [SectionController::class , 'create']);
Route::post('section/store' , [SectionController::class , 'store']);
Route::get('section/edit/{section}' , [SectionController::class , 'edit']);
Route::post('section/update/{section}' , [SectionController::class , 'update']);
Route::delete('sections/{sections}' , [SectionController::class , 'delete']);
Route::get('sections/export/excel/{sections}' , [SectionController::class , 'exportExcel']);
Route::get('sections/export/pdf/{sections}' , [SectionController::class , 'exportPdf']);
// ++++++++++ sections 




// ++++++++++ subjects 
Route::get('subjects' , [SubjectController::class , 'index']);
Route::get('subject/create' , [SubjectController::class , 'create']);
Route::post('subject/store' , [SubjectController::class , 'store']);
Route::get('subject/edit/{subject}' , [SubjectController::class , 'edit']);
Route::post('subject/update/{subject}' , [SubjectController::class , 'update']);
Route::delete('subjects/{subjects}' , [SubjectController::class , 'delete']);
Route::get('subjects/export/excel/{subjects}' , [SubjectController::class , 'exportExcel']);
Route::get('subjects/export/pdf/{subjects}' , [SubjectController::class , 'exportPdf']);
// ++++++++++ subjects 



Route::any('{query}',
    function () {return inertia('App/Errors/404');})
    ->where('query', '.*');
