<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\AdminUser;
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

class AdminController extends Controller {
    private static $UserModel;
    private static $TokenHelper;

    public function __construct() {
        self::$UserModel = new AdminUser();
        self::$TokenHelper = new TokenHelper();
    }
    
    # admin login page
    public function login(Request $request) {
        if ($request->session()->has('admin_email')) {
            return redirect('/admin/dashboard/');
        }
        $cookieUsername = Cookie::get('cookieUsername');
        $cookiePassword = Cookie::get('cookiePassword');
        return view('/admin/login', compact('cookieUsername', 'cookiePassword'));
    }

    public function get_IP_address() {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $IPaddress) {
                    $IPaddress = trim($IPaddress); // Just to be safe
                    if (filter_var($IPaddress, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $IPaddress;
                    }
                }
            }
        }
    }

    # admin dashboard page
    public function admin_login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email', 
            'password' => 'required', 
        ], [
            'email.required' => 'Please enter your email address.', 
            'email.email' => 'Please enter valid email address.', 
            'password.required' => 'Please enter your password.'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('email')) {
                echo json_encode(array('heading' => 'Error Email', 'msg' => $errors->first('email')));
            } else if ($errors->first('password')) {
                echo json_encode(array('heading' => 'Error Password', 'msg' => $errors->first('password')));
            }
        } else {
            if (isset($request->reminderMe) && $request->reminderMe == 1) {
                Cookie::queue('cookieUsername', $request->username, 5000);
                Cookie::queue('cookiePassword', $request->password, 5000);
            } else {
                Cookie::queue('cookieUsername', '', 5000);
                Cookie::queue('cookiePassword', '', 5000);
            }
            $User = self::$UserModel->where(array('email' => $request->email, 'status' => 1))->first();
            if ($User) {
                if ($User->type == 'Admin' || $User->type == 'Account' || $User->type == 'Employee') {
                    $PasswordMatch = password_verify($request->password, $User->password);
                    if (!$PasswordMatch) {
                        echo json_encode(array('heading' => 'Error Account', 'msg' => 'Username and password incorrect'));
                    } else {
                        ############################
                        $latitude = $longitude = '';
                        if ($request->latitude && !empty($request->latitude)) {
                            $latitude = $request->latitude;
                        }
                        if ($request->longitude && !empty($request->longitude)) {
                            $longitude = $request->longitude;
                        }
                        if ($latitude == '' && $longitude == '') {
                            $ip = $this->get_IP_address();
                            //curl "ipinfo.io/183.83.55.190?token=3c6d9ffebdd43a"
                            $access_key = '3c6d9ffebdd43a'; // Replace with your token from ipinfo.io
                            $response = file_get_contents("http://ipinfo.io/{$ip}/json?token={$access_key}");
                            $location = json_decode($response, true);
                            $latitude = $longitude = '';
                            if (isset($location['loc'])) {
                                $latlong = explode(',', $location['loc']);
                                if (isset($latlong[0])) {
                                    $latitude = $latlong[0];
                                }
                                if (isset($latlong[1])) {
                                    $longitude = $latlong[1];
                                }
                            }
                        }
                        self::$UserModel->where(array('id' => $User->id))->update(array('latitude' => $latitude, 'longitude' => $longitude));
                        ###################################
                        session(['admin_login_time' => time(), 'admin_latitude' => $latitude, 'admin_longitude' => $longitude, 'admin_id' => $User->id, 'admin_email' => $User->email, 'admin_profile' => $User, 'admin_type' => $User->type, 'admin_name' => $User->name]);
                        echo json_encode(array('heading' => 'Success', 'msg' => ''));
                    }
                } else {
                    echo json_encode(array('heading' => 'Error Account', 'msg' => 'Username and password incorrect'));
                }
            } else {
                echo json_encode(array('heading' => 'Error Account', 'msg' => 'Username and password incorrect'));
            }
        }
    }

    # admin dashboard page
    public function dashboard(Request $request) {
        if (!$request->session()->has('admin_email')) {
            return redirect('/admin/');
        }
        if ($request->session()->has('admin_email')) {
            $this->checkLogin($request);
        }
        return view('/admin/dashboard');
    }
    
    # admin dashboard page
    public function logout(Request $request) {
        $request->session()->flush();
        return redirect('/admin/');
    }
}
