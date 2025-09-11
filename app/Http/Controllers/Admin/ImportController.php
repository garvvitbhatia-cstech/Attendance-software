<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Incentives;
use App\Models\EmployeeAttendence;
use App\RouteHelper;
use App\Models\TokenHelper;
use App\Models\Responses;
use App\Models\ShippingMethods;
use App\Models\PaymentMethods;
use ReallySimpleJWT\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Session;
use Validator;
use Mail;
use URL;
use Cookie;
use Illuminate\Validation\Rule;
use App\Models\Reviews;

class ImportController extends Controller {
    private static $User;
    private static $Incentives;
    private static $EmployeeAttendence;
    
    public function __construct() {
        self::$User = new User();
        self::$Incentives = new Incentives();
        self::$EmployeeAttendence = new EmployeeAttendence();
    }
   

    #importEmployeeAttendance
    public function importEmployeeAttendance(Request $request) {
        if (!$request->session()->has('admin_email')) {
            echo 'SessionExpired';
            die;
        }
        $fileName = $_FILES["file"]["tmp_name"];        
        if(isset($fileName) && !empty($fileName)){
            $csvMimes = array('application/csv', 'text/csv');
            if(!empty($_FILES['file']['name']) && $_FILES["file"]["size"] > 0 && in_array($_FILES['file']['type'], $csvMimes)){
                $file = fopen($fileName, "r");
                $num = 1;
                while(($column = fgetcsv($file, 10000, ",")) !== FALSE){
                    if ($num > 1){
                        $user = self::$User->where('emp_id', trim($column[2]))->where('status', 1)->first();
                        if(isset($user->id)){
                            if($column[1] != ''){
                                $date = date('Y-m-d', strtotime(trim($column[1])));
                                $explode = explode('-', trim($date));
                                if(isset($explode[0]) && isset($explode[1]) && isset($explode[2])){
                                    $explodmonth = $explode[1];
                                    if($explode[1] < 10){
                                        $var = ltrim($explode[1],'0');
                                        $explodmonth = '0'.$var;
                                    }
                                    $explodeyear = $explode[0];
                                    $explodeday = $explode[2];
                                    $count = self::$EmployeeAttendence->where('employee_id', $user->id)->where('day', $explodeday)->where('month', $explodmonth)->where('year', $explodeyear)->count();
                                    if($count == 0){
                                        $eightcolumn = trim($column[8]);
                                        if($eightcolumn == 'Present' || $eightcolumn == 'Absent' || $eightcolumn == 'Half Day'){
                                            $setData['in_status'] = $eightcolumn;
                                        }else{
                                            $setData['in_status'] = 'Absent';
                                        }
                                        $setData['employee_id'] = $user->id;
                                        $setData['latitude'] = 0;
                                        $setData['longitude'] = 0;
                                        $setData['check_in'] = $column[6];
                                        $setData['check_out'] = $column[7];                                        
                                        $setData['date'] = $date;
                                        $setData['day'] = $explodeday;
                                        $setData['month'] = $explodmonth;
                                        $setData['year'] = $explodeyear;
                                        self::$EmployeeAttendence->CreateRecord($setData);
                                    }
                                }
                            }
                        }
                    }
                    $num++;
                }
                echo 'Success';
                die;
            } else {
                echo 'InvalidFileType';
                die;
            }
        } else {
            echo 'ChoseFile';
            die;
        }
    }

    #importIncentive
    public function importIncentive(Request $request) {
        if (!$request->session()->has('admin_email')) {
            echo 'SessionExpired';
            die;
        }
        $fileName = $_FILES["file"]["tmp_name"];        
        if (isset($fileName) && !empty($fileName)) {
            $csvMimes = array('application/csv', 'text/csv');
            if (!empty($_FILES['file']['name']) && $_FILES["file"]["size"] > 0 && in_array($_FILES['file']['type'], $csvMimes)) {
                $file = fopen($fileName, "r");
                $num = 1;
                while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                    if ($num > 1) {
                        $user = self::$User->where('emp_id', trim($column[1]))->where('status', 1)->first();
                        if(isset($user->id)){
                            if ($column[2] != ''){
                                $date = date('Y-m-d', strtotime(trim($column[2])));
                                $explode = explode('-', trim($date));
                                if(isset($explode[0]) && isset($explode[1]) && isset($explode[2])){
                                    $explodmonth = $explode[1];
                                    if($explode[1] < 10){
                                        $var = ltrim($explode[1],'0');
                                        $explodmonth = '0'.$var;
                                    }
                                    $count = self::$Incentives->where('emp_id', $user->id)->where('month', $explodmonth)->where('year', $explode[0])->count();
                                    if($count == 0){
                                        $setData['emp_id'] = $user->id;
                                        $setData['amount'] = $column[3];
                                        $setData['incentive_date'] = $date;
                                        $setData['day'] = $explode[2];
                                        $setData['month'] = $explodmonth;
                                        $setData['year'] = $explode[0];
                                        $record = self::$Incentives->CreateRecord($setData);
                                    }
                                }
                            }
                        }
                    }
                    $num++;
                }
                echo 'Success';
                die;
            } else {
                echo 'InvalidFileType';
                die;
            }
        } else {
            echo 'ChoseFile';
            die;
        }
    }
}
