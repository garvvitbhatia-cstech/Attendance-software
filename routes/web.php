<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\AjaxController;

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


/*Route::get('/', function () {
    return view('welcome');
});*/


Route::get('/',[PagesController::class, 'employeeRegistration'])->name('pages.employee-registration');
Route::post('/save-employee',[AjaxController::class, 'employeeRegistration'])->name('pages.save-employee');

Route::get('/clear-cache', function(){
    Artisan::call('cache:clear');
    return "Cache is cleared";
});


require "api.php";
require "admin.php";
require "export.php";
require "import.php";
require "vendor.php";
require "report.php";