<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ExportController;

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

    Route::any('/export-enquiries',[ExportController::class, 'exportEnquiries'])->name('exports.enquiries');

    Route::any('/export-employee-attendance',[ExportController::class, 'exportEmployeeAttendance'])->name('exports.employee.attendance');

    Route::any('/export-employee',[ExportController::class, 'exportEmployee'])->name('exports.employee');

    Route::any('/export-incentive',[ExportController::class, 'exportIncentive'])->name('exports.incentive');

    Route::any('/export-payslip',[ExportController::class, 'exportPayslip'])->name('exports.payslip');

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    return $request->user();

});