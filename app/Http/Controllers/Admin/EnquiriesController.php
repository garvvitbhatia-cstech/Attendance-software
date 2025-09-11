<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Enquiries;
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

class EnquiriesController extends Controller {
    private static $Enquiries;
    private static $TokenHelper;
    
    public function __construct() {
        self::$TokenHelper = new TokenHelper();
        self::$Enquiries = new Enquiries();
    }

    #admin dashboard page
    public function getList(Request $request) {
        if (!$request->session()->has('admin_email')) {
            return redirect('/admin/');
        }
        return view('/admin/enquiries/index');
    }

    public function listPaginate(Request $request) {
        if (!$request->session()->has('admin_email')) {
            return redirect('/admin/');
        }
        $query = self::$Enquiries->where('status', '!=', 3);
        if ($request->input('read_status') && $request->input('read_status') != "") {
            $read_status = $request->input('read_status');
            $query->where('read_status', $read_status);
        }
        if ($request->input('name') && $request->input('name') != "") {
            $name = $request->input('name');
            $query->where('name', 'like', '%' . $name . '%');
        }
        $records = $query->orderBy('id', 'DESC')->paginate(20);
        return view('/admin/enquiries/paginate', compact('records'));
    }

    #edit Service Type
    public function viewPage(Request $request, $row_id) {
        $RowID = base64_decode($row_id);
        if (!$request->session()->has('admin_email')) {
            return redirect('/admin/');
        }
        $rowData = self::$Enquiries->where(array('id' => $RowID))->first();
        if (isset($rowData->id)) {
            self::$Enquiries->where(array('id' => $RowID))->update(array('read_status' => 1));
            return view('/admin/enquiries/view-page', compact('rowData', 'row_id'));
        } else {
            return redirect('/admin/enquiries');
        }
    }
}
