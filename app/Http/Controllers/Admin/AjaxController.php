<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
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
use App\Models\State;

class AjaxController extends Controller {
    private static $TokenHelper;
    
    public function __construct() {
        self::$TokenHelper = new TokenHelper();
    }

    public function changeStatus(Request $request) {
        if (!$request->session()->has('admin_email')) {
            echo 'SessionExpire';
            die;
        }
        $tableName = $request->input('table');
        $rowID = $request->input('rowID');
        $status = $request->input('status');
        if ($tableName != "" && $rowID != "" && $status != "" && is_numeric($rowID) && is_numeric($status)) {
            if ($tableName == 'pathy' && $status == 1) {
                $categoryUsed = DB::table('practices')->where('pathy_id', $rowID)->where('status', 1)->count();
                if ($categoryUsed > 0) {
                    echo 'Cannot in-active this record (One or more practice are associated with this pathy.)';
                    die;
                }
            }
            $newStatus = $status == 1 ? 2 : 1;
            DB::table($tableName)->where(array('id' => $rowID))->update(array('status' => $newStatus));
            echo 'Success';
            die;
        } else {
            echo 'InvalidData';
            die;
        }
    }

    public function deleteRecord(Request $request) {
        if (!$request->session()->has('admin_email')) {
            echo 'SessionExpire';
            die;
        }
        $tableName = $request->input('table');
        $rowID = $request->input('rowID');
        if ($tableName != "" && $rowID != "" && is_numeric($rowID)) {
            if ($tableName == 'pathy') {
                $categoryUsed = DB::table('practices')->where('pathy_id', $rowID)->where('status', '!=', 3)->count();
                if ($categoryUsed > 0) {
                    echo 'Cannot delete this record (One or more practices are associated with this pathy.)';
                    die;
                }
            }
            DB::table($tableName)->where(array('id' => $rowID))->update(array('status' => 3));
            echo 'Success';
            die;
        } else {
            echo 'InvalidData';
            die;
        }
    }

    public function getState(Request $request) {
        if ($request->ajax()) {
            $country_id = $request->input('countryId');
            $states = DB::table('states')->where('country_id', $country_id)->where('status', 1)->orderBy('state')->pluck('state', 'id');
            echo view('/admin/ajax/get_state', compact('states'));
        }
        exit;
    }

    public function getCity(Request $request) {
        if ($request->ajax()) {
            $state_id = $request->input('stateId');
            $cities = DB::table('cities')->where('state_id', $state_id)->where('status', 1)->orderBy('city')->pluck('city', 'id');
            echo view('/admin/ajax/get_city', compact('cities'));
        }
        exit;
    }

    public function getEmployeeList(Request $request) {
        if ($request->ajax()) {
            $postData = $request->all();
            $json = array();
            if (isset($postData['q'])) {
                $term = $postData['q'];
                if ($term != '') {
                    $users = DB::table('users')->where('type', 'Employee')->where('name', 'like', '%' . $term . '%')->where('status', 1)->limit('20')->get();
                    foreach ($users as $key => $user) {
                        $json[] = ['id' => $user->id, 'title' => $user->name . ' (' . $user->emp_id . ') - ₹' . $user->salary];
                    }
                }
            }
            echo json_encode($json);
        }
        exit;
    }
}
