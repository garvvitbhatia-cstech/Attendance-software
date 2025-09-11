<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\InnerPages;
use App\RouteHelper;
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

class PagesController extends Controller {

    private static $InnerPages;
    public function __construct() {
        self::$InnerPages = new InnerPages();
    }

    #edit Service Type
    public function employeeRegistration(Request $request) {
        $inner_page = self::$InnerPages->where('status', 1)->where('id', 2)->first();
        return view('/pages/employee_registraion', compact('inner_page'));
    }
    
}
