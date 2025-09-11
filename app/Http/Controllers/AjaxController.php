<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\RouteHelper;
use App\Models\TokenHelper;
use App\Models\User;
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
use App\Mail\NewsletterMail;
use App\Mail\ContactMail;
use App\Models\State;

class AjaxController extends Controller {

    private static $TokenHelper;
    private static $User;

    public function __construct() {
        self::$TokenHelper = new TokenHelper();
        self::$User = new User();
    }

    public function employeeRegistration(Request $request) {
        if ($request->ajax()) {
            $postData = $request->all();
            $msg = '';
            if (isset($postData) && !empty($postData)) {
                $validator = Validator::make($request->all(), [
                    'first_name' => 'required', 
                    'email' => 'required|email|unique:users,email',
                    //'last_name' => 'required',
                    'father_name' => 'required', 
                    'correspondence_address' => 'required', 
                    'permanent_address' => 'required', 
                    'mobile' => 'required|digits:10', 
                    'telephone' => 'required|digits:10', 
                    'profile' => 'required|max:50480|mimes:jpg,png,webp,svg,jpeg', 
                    'aadhaar' => 'required|max:50480|mimes:jpg,png,webp,svg,jpeg', 
                    'dob' => 'required', 
                    'pan_card' => 'required|unique:users,pan_card', 
                    'emergency_name' => 'required', 
                    'emergency_relation' => 'required', 
                    'emergency_contact' => 'required|digits:10', 
                    'account_no' => 'required', 
                    'ifsc' => 'required', 
                    'bank_name' => 'required', 
                    'account_holder_name' => 'required', 
                    'account_image' => 'required|max:50480|mimes:jpg,png,webp,svg,jpeg'
                ], [
                    'first_name.required' => 'Please enter first name.', 
                    'email.required' => 'Please enter email.', 
                    'email.email' => 'Please enter valid email.', 
                    'email.unique' => 'Email already exists.',
                    //'last_name.required' => 'Please enter last name.',
                    'father_name.required' => 'Please enter father name.', 
                    'first_name.required' => 'Please enter first name.', 
                    'correspondence_address.required' => 'Please enter correspondence address.', 
                    'permanent_address.required' => 'Please enter permanent address.', 
                    'mobile.required' => 'Please enter mobile.', 
                    'mobile.digits' => 'Please enter valid mobile.', 
                    'telephone.required' => 'Please enter telephone number.', 
                    'telephone.digits' => 'Please enter valid telephone.', 
                    'profile.required' => 'Please select profile photo.', 
                    'profile.mimes' => 'Please select jpg,webp,png,svg files.', 
                    'aadhaar.required' => 'Please select aadhaar photo.', 
                    'aadhaar.mimes' => 'Please select jpg,webp,png,svg files.', 
                    'dob.required' => 'Please enter date of birth.', 
                    'pan_card.required' => 'Please enter pan card number.', 
                    'pan_card.unique' => 'PAN card already exists.', 
                    'emergency_contact.required' => 'Please enter emergency contact number.', 
                    'emergency_contact.digits' => 'Please enter valid emergency contact number.', 
                    'emergency_relation.required' => 'Please enter emergency contact relation.', 
                    'emergency_name.required' => 'Please enter emergency contact person name.', 
                    'account_no.required' => 'Please enter account number.', 
                    'ifsc.required' => 'Please enter IFSC code.', 
                    'bank_name.required' => 'Please enter bank name.', 
                    'account_holder_name.required' => 'Please enter account holder name.', 
                    'account_image.required' => 'Please select account image.', 
                    'account_image.mimes' => 'Please select jpg,webp,png,svg files.'
                ]);
                if ($validator->passes()) {
                    try {
                        if (isset($request->account_image) && $request->account_image->extension() != "") {
                            $validator = Validator::make($request->all(), ['account_image' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:20480']);
                            if ($validator->fails()) {
                                $errors = $validator->errors();
                                return json_encode(array('heading' => 'Error', 'msg' => $errors->first('account_image')));
                                die;
                            } else {
                                $actual_image_name = strtolower(sha1(str_shuffle(microtime(true) . mt_rand(100001, 999999)) . uniqid(rand() . true) . $request->file('account_image')) . '.' . $request->account_image->extension());
                                $destination = base_path() . '/public/admin/images/users/';
                                $request->account_image->move($destination, $actual_image_name);
                                $setData['account_image'] = $actual_image_name;
                            }
                        }
                        if (isset($request->profile) && $request->profile->extension() != "") {
                            $validator = Validator::make($request->all(), ['profile' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:20480']);
                            if ($validator->fails()) {
                                $errors = $validator->errors();
                                return json_encode(array('heading' => 'Error', 'msg' => $errors->first('profile')));
                                die;
                            } else {
                                $actual_image_name = strtolower(sha1(str_shuffle(microtime(true) . mt_rand(100001, 999999)) . uniqid(rand() . true) . $request->file('profile')) . '.' . $request->profile->extension());
                                $destination = base_path() . '/public/admin/images/users/';
                                $request->profile->move($destination, $actual_image_name);
                                $setData['profile'] = $actual_image_name;
                            }
                        }
                        if (isset($request->aadhaar) && $request->aadhaar->extension() != "") {
                            $validator = Validator::make($request->all(), ['aadhaar' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:20480']);
                            if ($validator->fails()) {
                                $errors = $validator->errors();
                                return json_encode(array('heading' => 'Error', 'msg' => $errors->first('aadhaar')));
                                die;
                            } else {
                                $actual_image_name = strtolower(sha1(str_shuffle(microtime(true) . mt_rand(100001, 999999)) . uniqid(rand() . true) . $request->file('aadhaar')) . '.' . $request->aadhaar->extension());
                                $destination = base_path() . '/public/admin/images/users/';
                                $request->aadhaar->move($destination, $actual_image_name);
                                $setData['aadhaar'] = $actual_image_name;
                            }
                        }
                        $fullname = $request->first_name . ' ' . $request->middle_name . ' ' . $request->last_name;
                        $this->newsletter($request->email, $fullname);
                        $setData['type'] = 'Employee';
                        $setData['first_name'] = ucwords(strtolower($request->first_name));
                        $setData['middle_name'] = ucwords(strtolower($request->middle_name));
                        $setData['last_name'] = ucwords(strtolower($request->last_name));
                        $setData['name'] = ucwords(strtolower($fullname));
                        $setData['father_name'] = ucwords(strtolower($request->father_name));
                        $setData['correspondence_address'] = $request->correspondence_address;
                        $setData['permanent_address'] = $request->permanent_address;
                        $setData['telephone'] = $request->telephone;
                        $setData['mobile'] = $request->mobile;
                        $setData['email'] = strtolower($request->email);
                        $password = password_hash(12345, PASSWORD_BCRYPT);
                        $setData['password'] = $password;
                        $setData['temp_password'] = $this->encryptData('12345');
                        $setData['dob'] = $request->dob;
                        $setData['marital_status'] = $request->marital_status;
                        $setData['pan_card'] = $request->pan_card;
                        $setData['blood_group'] = $request->blood_group;
                        $setData['emergency_name'] = $request->emergency_name;
                        $setData['emergency_relation'] = $request->emergency_relation;
                        $setData['emergency_contact'] = $request->emergency_contact;
                        $setData['account_no'] = $request->account_no;
                        $setData['ifsc'] = $request->ifsc;
                        $setData['bank_name'] = $request->bank_name;
                        $setData['account_holder_name'] = $request->account_holder_name;
                        $setData['education_degree'] = implode('|', $request->education_degree);
                        $setData['education_university'] = implode('|', $request->education_univesity);
                        $setData['education_from'] = implode('|', $request->education_from);
                        $setData['education_to'] = implode('|', $request->education_to);
                        $setData['education_percentage'] = implode('|', $request->education_percentage);
                        $setData['education_specialization'] = implode('|', $request->education_specialization);
                        $setData['employee_organisation'] = implode('|', $request->employee_organisation);
                        $setData['employee_designation'] = implode('|', $request->employee_designation);
                        $setData['employee_from_service_period'] = implode('|', $request->employee_from_service_period);
                        $setData['employee_to_service_period'] = implode('|', $request->employee_to_service_period);
                        $setData['employee_ctc'] = implode('|', $request->employee_ctc);
                        $setData['family_name'] = implode('|', $request->family_name);
                        $setData['family_relation'] = implode('|', $request->family_relation);
                        $setData['family_occupation'] = implode('|', $request->family_occupation);
                        $setData['family_dob'] = implode('|', $request->family_dob);
                        $setData['professional_name'] = implode('|', $request->professional_name);
                        $setData['professional_organisation'] = implode('|', $request->professional_organisation);
                        $setData['professional_designation'] = implode('|', $request->professional_designation);
                        $setData['professional_contact'] = implode('|', $request->professional_contact);
                        $record = self::$User->CreateRecord($setData);
                        $emp_id = 'EMP-' . $record->id;
                        self::$User->where(array('id' => $record->id))->update(array('emp_id' => $emp_id));
                        return response()->json(['status' => 'success', 'msg' => 'Employee register successfully.']);
                    }
                    catch(\Exception $e) {
                        echo $e->getMessage();
                        die;
                        return response()->json(['status' => 'error', 'msg' => 'Something went wrong.']);
                    }
                } else {
                    return response()->json(['status' => 'error', 'msg' => 'error', 'errors' => $validator->errors()->getMessages() ]);
                }
            }
            exit;
        }
    }

}