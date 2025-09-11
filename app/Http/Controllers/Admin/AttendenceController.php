<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EmployeeAttendence;
use App\RouteHelper;
use App\Models\TokenHelper;
use App\Models\Responses;
use ReallySimpleJWT\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Languages;
use Session;
use Validator;
use Mail;
use URL;
use Cookie;
use Illuminate\Validation\Rule;

class AttendenceController extends Controller {
    private static $User;
    private static $EmployeeAttendence;
    private static $TokenHelper;
    private static $Orders;

    public function __construct(){
        self::$EmployeeAttendence = new EmployeeAttendence();
        self::$User = new User();
        self::$TokenHelper = new TokenHelper();
    }

    #admin dashboard page
    public function getList(Request $request){
        if (!$request->session()->has('admin_email')){
            return redirect('/admin/');
        }
        if ($request->session()->get('admin_type') != 'Admin'){
            return redirect('/admin/');
        }
        if ($request->session()->has('admin_email')){
            $this->checkLogin($request);
        }
        if ($request->session()->get('admin_type')){
            if ($request->session()->get('admin_type') == 'Employee'){
                return redirect('/admin/');
            }
        }        
        return view('/admin/attendence_sheet/index');
    }

    public function listPaginate(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/admin/');
        }
        $query = self::$EmployeeAttendence->where('status', '!=', 3);
        if($request->session()->get('admin_id') > 1 && $request->session()->get('admin_type') == 'Employee'){
            $query->where('employee_id', $request->session()->get('admin_id'));
        }
        if($request->input('day') && $request->input('day') != ""){
            $day = $request->input('day');
            $query->where('day', $day);
        }
        if ($request->input('month') && $request->input('month') != ""){
            $month = $request->input('month');
            $query->where('month', $month);
        }
        if($request->input('in_status') && $request->input('in_status') != ""){
            $in_status = $request->input('in_status');
            $query->where('in_status', $in_status);
        }
        if($request->input('year') && $request->input('year') != ""){
            $year = $request->input('year');
            $query->where('year', $year);
        }
        if($request->input('name') && $request->input('name') != ""){
            $name = $request->input('name');
            $setDatas = '';
            $setDatas = array();
            $data = DB::table('users')->where('name', 'like', '%' . $name . '%')->where('status', '!=', 3)->get();
            foreach ($data as $key => $value) {
                if (isset($value->id)) {
                    $setDatas[] = $value->id;
                }
            }
            $implode = implode(',', array_unique($setDatas));
            $query->whereRaw('FIND_IN_SET(employee_id, ?)', [$implode]);
        }
        if($request->input('employee_id') && $request->input('employee_id') != ""){
            $employee_id = $request->input('employee_id');
            $setDatas = '';
            $setDatas = array();
            $data = DB::table('users')->where('emp_id', 'like', '%' . $employee_id . '%')->where('status', '!=', 3)->get();
            foreach ($data as $key => $value) {
                if (isset($value->id)) {
                    $setDatas[] = $value->id;
                }
            }
            $implode = implode(',', array_unique($setDatas));
            $query->whereRaw('FIND_IN_SET(employee_id, ?)', [$implode]);
        }
        if (!empty($request->input('from_date')) || !empty($request->input('to_date'))){
            $fdate = $tdate = '';
            if (!empty($request->input('from_date'))) {
                $fdate = date('Y-m-d', strtotime($request->input('from_date')));
            }
            if (!empty($request->input('to_date'))) {
                $tdate = date('Y-m-d', strtotime($request->input('to_date')));
            }
            if (!empty($fdate) && empty($tdate)) {
                $query->where('date', '>=', $fdate);
            } else if (empty($fdate) && !empty($tdate)) {
                $query->where('date', '<=', $tdate);
            } else {
                $query->whereBetween(DB::raw('DATE(date)'), [$fdate, $tdate]);
            }
        }
        $records = $query->orderBy('date', 'DESC')->paginate(20);
        $admin_id = $request->session()->get('admin_id');
        $admin_type = $request->session()->get('admin_type');
        return view('/admin/attendence_sheet/paginate', compact('records', 'admin_id', 'admin_type'));
    }

    public function updateAttendance(Request $request) {
        if ($request->ajax()) {
            $rowID = $request->row;
            $newStatus = $request->value;
            DB::table('attendence')->where(array('id' => $rowID))->update(array('in_status' => $newStatus));
        }
        exit;
    }
    
}
