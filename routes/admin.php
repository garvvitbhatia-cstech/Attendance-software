<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\AccountsController;
use App\Http\Controllers\Admin\AjaxController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\InnerPagesController;
use App\Http\Controllers\Admin\EnquiriesController;
use App\Http\Controllers\Admin\EmployeesController;
use App\Http\Controllers\Admin\EmployeeAttendenceController;
use App\Http\Controllers\Admin\AttendenceController;
use App\Http\Controllers\Admin\PayslipsController;
use App\Http\Controllers\Admin\AdvanceController;
use App\Http\Controllers\Admin\IncentivesController;

/*

|--------------------------------------------------------------------------

| API Routes


|--------------------------------------------------------------------------


|


| Here is where you can register API routes for your application. These



| routes are loaded by the RouteServiceProvider within a group which



| is assigned the "api" middleware group. Enjoy building your API!


|


*/
Route::prefix('admin')->group(function () {
   
    #account setup
    Route::get('/', [AdminController::class, 'login'])->name('admin.login');
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
   
    #dashboard setup
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin-login', [AdminController::class, 'admin_login'])->name('admin.admin_login');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
   
    #accounts
    Route::get('/accounts', [AccountsController::class, 'getList'])->name('admin.accounts');
    Route::any('/accounts_paginate', [AccountsController::class, 'listPaginate'])->name('admin.accounts_paginate');
    Route::any('/edit-account/{row_id}', [AccountsController::class, 'editPage'])->name('admin.edit-account');
    Route::any('/add-account', [AccountsController::class, 'addPage'])->name('admin.add-accounts');
  
    #super admins
    Route::get('/admins', [AdminsController::class, 'getList'])->name('admin.admins');
    Route::any('/admins_paginate', [AdminsController::class, 'listPaginate'])->name('admin.admins_paginate');
    Route::any('/edit-admin/{row_id}', [AdminsController::class, 'editPage'])->name('admin.edit-admins');
    Route::any('/add-admin', [AdminsController::class, 'addPage'])->name('admin.add-admins');
   
    #super admins
    Route::get('/incentives', [IncentivesController::class, 'getList'])->name('admin.incentives');
    Route::any('/incentives_paginate', [IncentivesController::class, 'listPaginate'])->name('admin.incentives_paginate');
    Route::any('/edit-incentive/{row_id}', [IncentivesController::class, 'editPage'])->name('admin.edit-incentive');
    Route::any('/add-incentive', [IncentivesController::class, 'addPage'])->name('admin.add-incentive');
    
    #Advance
    Route::get('/advance', [AdvanceController::class, 'getList'])->name('admin.advance');
    Route::any('/advance_paginate', [AdvanceController::class, 'listPaginate'])->name('admin.advance_paginate');
    Route::any('/edit-advance/{row_id}', [AdvanceController::class, 'editPage'])->name('admin.edit-advance');
    Route::any('/add-advance', [AdvanceController::class, 'addPage'])->name('admin.add-advance');
   
    #payslips
    Route::get('/payslips', [PayslipsController::class, 'getList'])->name('admin.payslips');
    Route::any('/payslips_paginate', [PayslipsController::class, 'listPaginate'])->name('admin.payslips_paginate');
    Route::any('/get-current-payslip', [PayslipsController::class, 'getCurrentPayslip'])->name('admin.get-current-payslip');
    Route::any('/generate-employee-payslip', [PayslipsController::class, 'generateEmployeePayslip'])->name('admin.generate-employee-payslip');
    Route::any('/update-total-leave', [PayslipsController::class, 'updateTotalLeave'])->name('admin.update-total-leave');
  
    #ajax
    Route::post('/change-status', [AjaxController::class, 'changeStatus'])->name('admin.change-status');
    Route::post('/delete-record', [AjaxController::class, 'deleteRecord'])->name('admin.delete-record');
    Route::any('/get-employee-list', [AjaxController::class, 'getEmployeeList'])->name('admin.get-employee-list');
   
    #inner pages
    Route::get('/inner-pages', [InnerPagesController::class, 'getList'])->name('admin.inner-pages');
    Route::any('/inner_pages_paginate', [InnerPagesController::class, 'listPaginate'])->name('admin.inner_pages_paginate');
    Route::any('/edit-inner-page/{row_id}', [InnerPagesController::class, 'editPage'])->name('admin.edit-inner-page');
   
    #enquiries
    Route::get('/enquiries', [EnquiriesController::class, 'getList'])->name('admin.enquiries');
    Route::any('/enquiries_paginate', [EnquiriesController::class, 'listPaginate'])->name('admin.enquiries_paginate');
    Route::any('/view-enquiry/{row_id}', [EnquiriesController::class, 'viewPage'])->name('admin.view-enquiry');
   
    #settings
    Route::get('/settings', [ProfileController::class, 'settings'])->name('admin.settings');
    Route::post('/save-setting', [ProfileController::class, 'saveSetting'])->name('admin.save-setting');
   
    #update profile
    Route::get('/update-profile', [ProfileController::class, 'updateProfile'])->name('admin.update-profile');
    Route::post('/save-profile', [ProfileController::class, 'saveProfile'])->name('admin.save-profile');
   
    #change password
    Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('admin.change-password');
    Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('admin.dashboard');
    
    #Users
    Route::get('/users', [UsersController::class, 'getList'])->name('admin.users');
    Route::any('/users_paginate', [UsersController::class, 'listPaginate'])->name('admin.users_paginate');
    Route::any('/add-user', [UsersController::class, 'addPage'])->name('admin.add-user');
    Route::any('/edit-user/{row_id}', [UsersController::class, 'editPage'])->name('admin.edit-user');
   
    #Employee
    Route::get('/employees', [EmployeesController::class, 'getList'])->name('admin.employees');
    Route::any('/employee_paginate', [EmployeesController::class, 'listPaginate'])->name('admin.employee_paginate');
    Route::any('/add-employee', [EmployeesController::class, 'addPage'])->name('admin.add-employee');
    Route::any('/edit-employee/{row_id}', [EmployeesController::class, 'editPage'])->name('admin.edit-employee');
    Route::any('/print-offer-letter', [EmployeesController::class, 'printOfferLetter'])->name('admin.edit-employee');
    
    #attendence
    Route::get('/attendence', [AttendenceController::class, 'getList'])->name('admin.attendence');
    Route::any('/attendence_paginate', [AttendenceController::class, 'listPaginate'])->name('admin.attendence_paginate');
    Route::any('/add-attendence', [AttendenceController::class, 'addPage'])->name('admin.add-attendence');
    Route::any('/edit-attendence/{row_id}', [AttendenceController::class, 'editPage'])->name('admin.edit-attendence');
    Route::any('/update-attendence', [AttendenceController::class, 'updateAttendance'])->name('admin.update-attendence');

    #Employee attendence
    Route::get('/employee-attendence', [EmployeeAttendenceController::class, 'getList'])->name('admin.employee-attendence');
    Route::post('/save-attendence', [EmployeeAttendenceController::class, 'saveAttendence'])->name('admin.save-attendence');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
