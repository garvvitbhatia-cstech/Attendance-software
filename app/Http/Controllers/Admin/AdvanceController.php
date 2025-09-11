<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Advance;
use App\Models\User;
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

class AdvanceController extends Controller {
    private static $Advance;
    private static $User;

    public function __construct() {
        self::$Advance = new Advance();
        self::$User = new User();
    }

    #admin dashboard page
    public function getList(Request $request) {
        if (!$request->session()->has('admin_email')) {
            return redirect('/admin/');
        }
        return view('/admin/advance/index');
    }

    public function listPaginate(Request $request) {
        if (!$request->session()->has('admin_email')) {
            return redirect('/admin/');
        }
        $query = self::$Advance->where('status', '!=', 3);
        if ($request->input('employee_id') && $request->input('employee_id') != "") {
            $employee_id = $request->input('employee_id');
            $data = DB::table('users')->where('name', 'like', '%' . $employee_id . '%')->where('status', '!=', 3)->get();
            $setDatas = array();
            foreach ($data as $key => $value) {
                if (isset($value->id)) {
                    $setDatas[] = $value->id;
                }
            }
            $implode = implode(',', array_unique($setDatas));
            $query->whereRaw('FIND_IN_SET(user_id, ?)', [$implode]);
        }
        if (!empty($request->input('from_date')) || !empty($request->input('to_date'))) {
            if (!empty($request->input('from_date')) && empty($request->input('to_date'))) {
                $query->where('date', $request->input('from_date'));
            } else if (empty($request->input('from_date')) && !empty($request->input('to_date'))) {
                $query->where('date', '<=', $request->input('to_date'));
            } else {
                $query->where('date', '>=', $request->input('from_date'));
                $query->where('date', '<=', $request->input('to_date'));
            }
        }
        $records = $query->orderBy('id', 'DESC')->paginate(20);
        return view('/admin/advance/paginate', compact('records'));
    }

    #add new Service Type
    public function addPage(Request $request) {
        if (!$request->session()->has('admin_email')) {
            return redirect('/admin/');
        }
        if ($request->input()) {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required', 
                'amount' => 'required', 
                'date' => 'required'
            ], [
                'user_id.required' => 'Please select employee.', 
                'amount.required' => 'Please enter advance amount.', 
                'date.required' => 'Please enter date.'
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                if ($errors->first('user_id')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('user_id')));
                    die;
                }
                if ($errors->first('amount')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('amount')));
                    die;
                }
                if ($errors->first('date')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('date')));
                    die;
                }
            } else {
                $setData['user_id'] = $request->input('user_id');
                $setData['amount'] = $request->input('amount');
                $setData['installment'] = $request->input('installment');
                $setData['date'] = $request->input('date');
                $setData['mode'] = $request->input('mode');
                $setData['day'] = date('d', strtotime($request->input('date')));
                $setData['month'] = date('m', strtotime($request->input('date')));
                $setData['year'] = date('Y', strtotime($request->input('date')));
                $record = self::$Advance->CreateRecord($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Advance details added successfully'));
                die;
            }
        }
        return view('/admin/advance/add-page');
    }

    #edit Service Type
    public function editPage(Request $request, $row_id) {
        $RowID = base64_decode($row_id);
        if (!$request->session()->has('admin_email')) {
            return redirect('/admin/');
        }
        if ($request->input()) {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required', 
                'amount' => 'required', 
                'date' => 'required'
            ], [
                'user_id.required' => 'Please select employee.', 
                'amount.required' => 'Please enter advance amount.', 
                'date.required' => 'Please enter date.'
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                if ($errors->first('user_id')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('user_id')));
                    die;
                }
                if ($errors->first('amount')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('amount')));
                    die;
                }
                if ($errors->first('date')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('date')));
                    die;
                }
            } else {
                $setData['id'] = $RowID;
                $setData['user_id'] = $request->input('user_id');
                $setData['amount'] = $request->input('amount');
                $setData['installment'] = $request->input('installment');
                $setData['date'] = $request->input('date');
                $setData['mode'] = $request->input('mode');
                $setData['day'] = date('d', strtotime($request->input('date')));
                $setData['month'] = date('m', strtotime($request->input('date')));
                $setData['year'] = date('Y', strtotime($request->input('date')));
                self::$Advance->UpdateRecord($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Advance details updated successfully'));
                die;
            }
        }
        $rowData = self::$Advance->where(array('id' => $RowID))->first();
        if (isset($rowData->id)) {
            $user = self::$User->where(array('status' => 1, 'id' => $rowData->user_id))->first();
            return view('/admin/advance/edit-page', compact('rowData', 'row_id', 'user'));
        } else {
            return redirect('/admin/advance');
        }
    }
}
