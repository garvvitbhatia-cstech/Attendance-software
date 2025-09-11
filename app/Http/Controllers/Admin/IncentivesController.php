<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Incentives;
use App\RouteHelper;
use App\Models\TokenHelper;
use App\Models\Responses;
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

class IncentivesController extends Controller {
    private static $User;
    private static $Incentives;

    public function __construct() {
        self::$User = new User();
        self::$Incentives = new Incentives();
    }

    #admin dashboard page
    public function getList(Request $request) {
        if (!$request->session()->has('admin_email')) {
            return redirect('/admin/');
        }
        if ($request->session()->get('admin_type')) {
            if ($request->session()->get('admin_type') == 'Employee') {
                return redirect('/admin/');
            }
        }
        return view('/admin/incentives/index');
    }

    public function listPaginate(Request $request) {
        if (!$request->session()->has('admin_email')) {
            return redirect('/admin/');
        }
        $query = self::$Incentives->where('status', '!=', 3);
        if ($request->input('name') && $request->input('name') != "") {
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
            $query->whereRaw('FIND_IN_SET(emp_id, ?)', [$implode]);
        }
        if ($request->input('employee_id') && $request->input('employee_id') != "") {
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
            $query->whereRaw('FIND_IN_SET(emp_id, ?)', [$implode]);
        }
        if (!empty($request->input('from_date')) || !empty($request->input('to_date'))) {
            $fdate = $tdate = '';
            if (!empty($request->input('from_date'))) {
                $fdate = date('Y-m-d', strtotime($request->input('from_date')));
            }
            if (!empty($request->input('to_date'))) {
                $tdate = date('Y-m-d', strtotime($request->input('to_date')));
            }
            if (!empty($fdate) && empty($tdate)) {
                $query->where('incentive_date', '>=', $fdate);
            } else if (empty($fdate) && !empty($tdate)) {
                $query->where('incentive_date', '<=', $tdate);
            } else {
                $query->whereBetween(DB::raw('DATE(incentive_date)'), [$fdate, $tdate]);
            }
        }
        $records = $query->orderBy('id', 'DESC')->paginate(20);
        return view('/admin/incentives/paginate', compact('records'));
    }

    #add new Service Type
    public function addPage(Request $request) {
        if (!$request->session()->has('admin_email')) {
            return redirect('/admin/');
        }
        if ($request->session()->get('admin_type')) {
            if ($request->session()->get('admin_type') == 'Employee') {
                return redirect('/admin/');
            }
        }
        if ($request->input()) {
            $validator = Validator::make($request->all(), [
                'emp_id' => 'required', 
                'day' => 'required', 
                'month' => 'required', 
                'year' => 'required', 
                'amount' => 'required'
            ], [
                'emp_id.required' => 'Please enter employee name.', 
                'day.required' => 'Please enter day.', 
                'month.required' => 'Please enter month.', 
                'year.required' => 'Please enter year.', 
                'amount.required' => 'Please enter amount.',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                if ($errors->first('day')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('day')));
                    die;
                }
                if ($errors->first('month')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('month')));
                    die;
                }
                if ($errors->first('year')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('year')));
                    die;
                }
                if ($errors->first('emp_id')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('emp_id')));
                    die;
                }
                if ($errors->first('amount')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('amount')));
                    die;
                }
            } else {
                $date = date('Y-m-d', strtotime($request->input('year') . '-' . $request->input('month') . '-' . $request->input('day')));
                $count = self::$Incentives->where('emp_id', $request->input('emp_id'))->where('month', $request->input('month'))->where('year', $request->input('year'))->count();
                if ($count == 0) {
                    $setData['emp_id'] = $request->input('emp_id');
                    $setData['amount'] = $request->input('amount');
                    $setData['incentive_date'] = $date;
                    $setData['day'] = $request->input('day');
                    $setData['month'] = $request->input('month');
                    $setData['year'] = $request->input('year');
                    $record = self::$Incentives->CreateRecord($setData);
                    echo json_encode(array('heading' => 'Success', 'msg' => 'Incentive details added successfully'));
                } else {
                    echo json_encode(array('heading' => 'Error', 'msg' => 'Incentive already exists.'));
                }
                die;
            }
        }
        return view('/admin/incentives/add-page');
    }

    #edit Service Type
    public function editPage(Request $request, $row_id) {
        $RowID = base64_decode($row_id);
        if (!$request->session()->has('admin_email')) {
            return redirect('/admin/');
        }
        if ($request->session()->get('admin_type')) {
            if ($request->session()->get('admin_type') == 'Employee') {
                return redirect('/admin/');
            }
        }
        if ($request->input()) {
            $validator = Validator::make($request->all(), [
                'emp_id' => 'required', 
                'day' => 'required', 
                'month' => 'required', 
                'year' => 'required', 
                'amount' => 'required'
            ], [
                'emp_id.required' => 'Please enter employee name.', 
                'day.required' => 'Please enter day.', 
                'month.required' => 'Please enter month.', 
                'year.required' => 'Please enter year.', 
                'amount.required' => 'Please enter amount.', 
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                if ($errors->first('day')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('day')));
                    die;
                }
                if ($errors->first('month')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('month')));
                    die;
                }
                if ($errors->first('year')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('year')));
                    die;
                }
                if ($errors->first('emp_id')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('emp_id')));
                    die;
                }
                if ($errors->first('amount')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('amount')));
                    die;
                }
            } else {
                $date = date('Y-m-d', strtotime($request->input('year') . '-' . $request->input('month') . '-' . $request->input('day')));
                $count = self::$Incentives->where('emp_id', $request->input('emp_id'))->where('month', $request->input('month'))->where('year', $request->input('year'))->where('id', '!=', $RowID)->count();
                if ($count > 0) {
                    echo json_encode(array('heading' => 'Error', 'msg' => 'Incentive details already exists.'));
                    die;
                } else {
                    $setData['id'] = $RowID;
                    $setData['emp_id'] = $request->input('emp_id');
                    $setData['amount'] = $request->input('amount');
                    $setData['incentive_date'] = $date;
                    $setData['day'] = $request->input('day');
                    $setData['month'] = $request->input('month');
                    $setData['year'] = $request->input('year');
                    self::$Incentives->UpdateRecord($setData);
                }
                echo json_encode(array('heading' => 'Success', 'msg' => 'Incentive details updated successfully'));
                die;
            }
        }
        $rowData = self::$Incentives->where(array('id' => $RowID))->first();
        if (isset($rowData->id)) {
            $user = self::$User->where(array('id' => $rowData->emp_id))->first();
            return view('/admin/incentives/edit-page', compact('rowData', 'row_id', 'user'));
        } else {
            return redirect('/admin/incentives');
        }
    }
}
