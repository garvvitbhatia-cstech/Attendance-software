<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Settings;
use App\Models\EmployeeAttendence;
use App\RouteHelper;
use App\Models\TokenHelper;
use App\Models\Responses;
use ReallySimpleJWT\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use App\Models\Languages;
use Session;
use Validator;
use Mail;
use URL;
use Cookie;
use Illuminate\Validation\Rule;

class EmployeeAttendenceController extends Controller {
    private static $User;
    private static $TokenHelper;
    private static $EmployeeAttendence;
    private static $Settings;
    
    public function __construct() {
        self::$User = new User();
        self::$EmployeeAttendence = new EmployeeAttendence();
        self::$Settings = new Settings();
        self::$TokenHelper = new TokenHelper();
    }

    #admin dashboard page
    public function getList(Request $request) {
        if (!$request->session()->has('admin_email')) {
            return redirect('/admin/');
        }
        if ($request->session()->has('admin_email')) {
            $this->checkLogin($request);
        }
        $user_id = $request->session()->get('admin_id');
        return view('/admin/employee_attendence/index', compact('user_id'));
    }

    public function saveAttendence(Request $request) {
        if (!$request->session()->has('admin_email')) {
            echo 'SessionExpire';
            die;
        }
        if ($request->ajax()) {
            $setting = self::$Settings->where('id', 1)->first();
            $emp_id = $request->session()->get('admin_id');
            $date = date('Y-m-d');
            $userDetails = self::$User->where('id', $emp_id)->where('status', 1)->first();
            $latitude = $userDetails->latitude;
            $longitude = $userDetails->longitude;
            $current_time = date('d-m-Y h:i a');
            $record = self::$EmployeeAttendence->where('employee_id', $emp_id)->where('date', $date)->where('status', '!=', 3)->first();
            if (isset($record->id)) {
                self::$EmployeeAttendence->where(array('id' => $record->id))->update(array('check_out' => $current_time));
                echo json_encode(array('heading' => 'Success', 'msg' => 'Logout successfully'));
                die;
            } else {
                if (isset($request->image) && $request->image->extension() != "") {
                    $validator = Validator::make($request->all(), ['image' => 'required|image|mimes:jpeg,jpg,png,svg,webp|max:20480']);
                    if ($validator->fails()) {
                        $errors = $validator->errors();
                        return json_encode(array('heading' => 'Error', 'msg' => $errors->first('image')));
                        die;
                    } else {
                        $yeardir = trim(date('Y'));
                        $monthdir = trim(date('m'));
                        if(!File::exists(public_path('/admin/images/screenshot/'.$yeardir))){
                            mkdir(public_path('/admin/images/screenshot/'.$yeardir, 0777, true));
                        }
                        if(!File::exists(public_path('/admin/images/screenshot/'.$yeardir.'/'.$monthdir))){
                            mkdir(public_path('/admin/images/screenshot/'.$yeardir.'/'.$monthdir, 0777, true));
                        }
                        $actual_image_name = str_shuffle(time() . mt_rand()) . '1.' . $request->image->extension();
                        $destination = base_path() . '/public/admin/images/screenshot/'.$yeardir.'/'.$monthdir.'/';
                        if($request->image->move($destination, $actual_image_name)){
                            $setData['image'] = $actual_image_name;
                        }
                        $in_status = 'Present';
                        if (isset($setting->id)) {
                            $halfday_time = $setting->halfday_time;
                            $absent_time = $setting->absent_time;
                            if (time() > strtotime(date('Y-m-d') . ' ' . $halfday_time)) {
                                $in_status = 'Half Day';
                            }
                            if (time() > strtotime(date('Y-m-d') . ' ' . $absent_time)) {
                                $in_status = 'Absent';
                            }
                        }
                        $setData['message'] = $request->message;
                        $setData['employee_id'] = $emp_id;
                        $setData['latitude'] = $latitude;
                        $setData['longitude'] = $longitude;
                        $setData['check_in'] = $current_time;
                        $setData['in_status'] = $in_status;
                        $setData['date'] = date('Y-m-d');
                        $setData['day'] = date('d');
                        $setData['month'] = date('m');
                        $setData['year'] = date('Y');
                        self::$EmployeeAttendence->CreateRecord($setData);
                        echo json_encode(array('heading' => 'Success', 'msg' => 'Login Successfully'));
                        die;
                    }
                } else {
                    return json_encode(array('heading' => 'Error', 'msg' => 'Please upload current screenshot.'));
                    die;
                }
            }
        }
        exit;
    }
}
