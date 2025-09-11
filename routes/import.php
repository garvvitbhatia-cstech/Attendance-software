<?php
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ImportController;


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

Route::prefix('admin')->group(function(){	

	Route::any('/import-incentive',[ImportController::class, 'importIncentive'])->name('imports.incentive');

    Route::any('/import-customer',[ImportController::class, 'importCustomer'])->name('imports.customer');

    Route::any('/import-employee-attendance',[ImportController::class, 'importEmployeeAttendance'])->name('imports.employee-attendance');

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request){

    return $request->user();

});