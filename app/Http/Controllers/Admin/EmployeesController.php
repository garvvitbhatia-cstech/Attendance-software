<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
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
use Mpdf\Mpdf;

class EmployeesController extends Controller {
    private static $User;
    private static $TokenHelper;

    public function __construct() {
        self::$User = new User();
        self::$TokenHelper = new TokenHelper();
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
        return view('/admin/employees/index');
    }

    public function listPaginate(Request $request) {
        if (!$request->session()->has('admin_email')) {
            return redirect('/admin/');
        }
        $count = self::$User->where('status', '!=', 3)->where('type', 'Employee')->count();
        $query = self::$User->where('status', '!=', 3)->where('type', 'Employee');
        if ($request->input('status') && $request->input('status') != "") {
            $status = $request->input('status');
            $query->where('status', $status);
        }
        if ($request->input('name') && $request->input('name') != "") {
            $name = $request->input('name');
            $query->where('name', 'like', '%' . $name . '%');
        }
        if ($request->input('email') && $request->input('email') != "") {
            $email = $request->input('email');
            $query->where('email', 'like', '%' . $email . '%');
        }
        if ($request->input('mobile') && $request->input('mobile') != "") {
            $mobile = $request->input('mobile');
            $query->where('mobile', 'like', '%' . $mobile . '%');
        }
        $records = $query->orderBy('id', 'DESC')->paginate(20);
        return view('/admin/employees/paginate', compact('records', 'count'));
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
        $rowData = self::$User->where(array('id' => $RowID))->first();
        if ($request->input()) {
            $validator = Validator::make($request->all(), [                
                'emp_id' => 'required', 
                'first_name' => 'required', 
                'email' => 'required|email',
                //'last_name' => 'required',
                'father_name' => 'required', 
                'salary' => 'required', 
                'correspondence_address' => 'required', 
                'permanent_address' => 'required', 
                'mobile' => 'required|digits:10',
                'telephone' => 'required|digits:10', 
                'profile' => 'nullable|max:50480|mimes:jpg,png,webp,svg', 
                'aadhaar' => 'nullable|max:50480|mimes:jpg,png,webp,svg', 
                'dob' => 'required', 
                'pan_card' => 'required', 
                'emergency_name' => 'required', 
                'emergency_relation' => 'required', 
                'emergency_contact' => 'required|digits:10', 
                'account_no' => 'required', 
                'ifsc' => 'required', 
                'bank_name' => 'required', 
                'account_holder_name' => 'required', 
                'account_image' => 'max:50480|mimes:jpg,png,webp,svg', 
            ], [
                'emp_id.required' => 'Please enter employee id.', 
                'first_name.required' => 'Please enter first name.', 
                'email.required' => 'Please enter email.', 
                'email.email' => 'Please enter valid email.',
                //'last_name.required' => 'Please enter last name.',
                'father_name.required' => 'Please enter father name.', 
                'salary.required' => 'Please enter salary.', 
                'correspondence_address.required' => 'Please enter correspondence address.', 
                'permanent_address.required' => 'Please enter permanent address.', 
                'mobile.required' => 'Please enter mobile.', 
                'mobile.digits' => 'Please enter valid mobile.', 
                'telephone.required' => 'Please enter telephone number.', 
                'telephone.digits' => 'Please enter valid telephone.', 
                'profile.mimes' => 'Please select jpg,webp,png,svg files.', 
                'aadhaar.mimes' => 'Please select jpg,webp,png,svg files.', 
                'dob.required' => 'Please enter date of birth.', 
                'pan_card.required' => 'Please enter pan card number.', 
                'emergency_contact.required' => 'Please enter emergency contact number.', 
                'emergency_contact.digits' => 'Please enter valid emergency contact number.', 
                'emergency_relation.required' => 'Please enter emergency contact relation.', 
                'emergency_name.required' => 'Please enter emergency contact person name.', 
                'account_no.required' => 'Please enter account number.', 
                'ifsc.required' => 'Please enter IFSC code.', 
                'bank_name.required' => 'Please enter bank name.', 
                'account_holder_name.required' => 'Please enter account holder name.', 
                'account_image.mimes' => 'Please select jpg,webp,png,svg files.'
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                if ($errors->first('emp_id')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('emp_id')));
                    die;
                }
                if ($errors->first('first_name')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('first_name')));
                    die;
                }
                if ($errors->first('email')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('email')));
                    die;
                }
                //if($errors->first('last_name')){
                //   return json_encode(array('heading'=>'Error','msg'=>$errors->first('last_name')));die;
                //}
                if ($errors->first('salary')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('salary')));
                    die;
                }
                if ($errors->first('father_name')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('father_name')));
                    die;
                }
                if ($errors->first('correspondence_address')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('correspondence_address')));
                    die;
                }
                if ($errors->first('permanent_address')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('permanent_address')));
                    die;
                }
                if ($errors->first('mobile')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('mobile')));
                    die;
                }
                if ($errors->first('telephone')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('telephone')));
                    die;
                }
                if ($errors->first('profile')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('profile')));
                    die;
                }
                if ($errors->first('aadhaar')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('aadhaar')));
                    die;
                }
                if ($errors->first('dob')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('dob')));
                    die;
                }
                if ($errors->first('pan_card')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('pan_card')));
                    die;
                }
                if ($errors->first('emergency_contact')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('emergency_contact')));
                    die;
                }
                if ($errors->first('emergency_relation')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('emergency_relation')));
                    die;
                }
                if ($errors->first('emergency_name')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('emergency_name')));
                    die;
                }
                if ($errors->first('account_no')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('account_no')));
                    die;
                }
                if ($errors->first('ifsc')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('ifsc')));
                    die;
                }
                if ($errors->first('bank_name')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('bank_name')));
                    die;
                }
                if ($errors->first('account_holder_name')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('account_holder_name')));
                    die;
                }
                if ($errors->first('account_image')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('account_image')));
                    die;
                }
            } else {
                if (self::$User->ExistingRecordUpdate($request->input('email'), $RowID)) {
                    echo json_encode(array('heading' => 'Error', 'msg' => 'Employee already exists.'));
                    die;
                } else {
                    $pan_card_count = self::$User->where(array('pan_card' => trim($request->pan_card)))->where('id', '!=', $RowID)->where('status', '!=', 3)->count();
                    if ($pan_card_count > 0) {
                        echo json_encode(array('heading' => 'Error', 'msg' => 'Pan card already exists.'));
                        die;
                    } else {
                        $setData['id'] = $RowID;
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
                                if ($rowData->account_image != "") {
                                    if (file_exists($destination . $rowData->account_image)) {
                                        unlink($destination . $rowData->account_image);
                                    }
                                }
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
                                if ($rowData->profile != "") {
                                    if (file_exists($destination . $rowData->profile)) {
                                        unlink($destination . $rowData->profile);
                                    }
                                }
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
                                if ($rowData->aadhaar != "") {
                                    if (file_exists($destination . $rowData->aadhaar)) {
                                        unlink($destination . $rowData->aadhaar);
                                    }
                                }
                            }
                        }
                        $fullname = $request->first_name . ' ' . $request->middle_name . ' ' . $request->last_name;
                        $this->newsletter($request->email, $fullname);
                        $setData['type'] = 'Employee';
                        $emp_id = 'EMP-' . $RowID;
                        $setData['emp_id'] = $request->emp_id;
                        $setData['first_name'] = ucwords(strtolower($request->first_name));
                        $setData['middle_name'] = ucwords(strtolower($request->middle_name));
                        $setData['last_name'] = ucwords(strtolower($request->last_name));
                        $setData['name'] = ucwords(strtolower($fullname));
                        $setData['salary'] = $request->salary;
                        $setData['father_name'] = ucwords(strtolower($request->father_name));
                        $setData['correspondence_address'] = $request->correspondence_address;
                        $setData['permanent_address'] = $request->permanent_address;
                        $setData['telephone'] = $request->telephone;
                        $setData['mobile'] = $request->mobile;
                        $setData['email'] = strtolower($request->email);
                        $password = password_hash($request->password, PASSWORD_BCRYPT);
                        $setData['password'] = $password;
                        $setData['temp_password'] = $this->encryptData($request->password);
                        $setData['dob'] = $request->dob;
                        $setData['marital_status'] = $request->marital_status;
                        $setData['pan_card'] = $request->pan_card;
                        $setData['blood_group'] = $request->blood_group;
                        $setData['account_no'] = $request->account_no;
                        $setData['ifsc'] = $request->ifsc;
                        $setData['bank_name'] = $request->bank_name;
                        $setData['account_holder_name'] = $request->account_holder_name;
                        $setData['emergency_name'] = $request->emergency_name;
                        $setData['emergency_relation'] = $request->emergency_relation;
                        $setData['emergency_contact'] = $request->emergency_contact;
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
                        self::$User->UpdateRecord($setData);
                    }
                }
                echo json_encode(array('heading' => 'Success', 'msg' => 'Employee updated successfully'));
                die;
            }
        }
        if (isset($rowData->id)) {
            if (!empty($rowData->temp_password)) {
                $rowData->temp_password = $this->decryptData($rowData->temp_password);
            }
            return view('/admin/employees/edit-page', compact('rowData', 'row_id'));
        } else {
            return redirect('/admin/employees');
        }
    }

    public function convert_in_words($number) {
        $no = round($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => '', '1' => 'one', '2' => 'two', '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six', '7' => 'seven', '8' => 'eight', '9' => 'nine', '10' => 'ten', '11' => 'eleven', '12' => 'twelve', '13' => 'thirteen', '14' => 'fourteen', '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen', '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty', '30' => 'thirty', '40' => 'forty', '50' => 'fifty', '60' => 'sixty', '70' => 'seventy', '80' => 'eighty', '90' => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i+= ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str[] = ($number < 21) ? $words[$number] . " " . $digits[$counter] . $plural . " " . $hundred : $words[floor($number / 10) * 10] . " " . $words[$number % 10] . " " . $digits[$counter] . $plural . " " . $hundred;
            } else $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ? "." . $words[$point / 10] . " " . $words[$point = $point % 10] : '';
        return ucwords($result);
    }

    public function printOfferLetter(Request $request) {
        $row_id = base64_decode($request->rowID);
        $userData = self::$User->where('id', $row_id)->first();
        $destination = base_path() . '/public/img/logo/logo.png';
        $html = '<table class="table" cellspacing="0" width="100%">';
        $html.= '<tr>';
        $html.= '<td colspan="1" style="padding:5px; font-family:tahoma;font-size:21px" align="left"><img src=' . $destination . ' style="max-width:100px;height: auto;"></td>';
        $html.= '<td colspan="5" style="padding:5px; font-family:tahoma;font-size:21px" align="left"><strong>KAUSHAL ENTERPRISES</strong></td>';
        $html.= '</tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">' . ucwords(strtolower($userData->name)) . ',</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">India</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">Pincode - </td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">Subject: Appointment for the post of -.</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">Dear <b>' . ucwords(strtolower($userData->name)) . ',</b></td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">We are pleased to offer you, the position of Sales Consultant with Kaushal Enterprises on the following terms and conditions:</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left"><b>1. Commencement of employment</b><br>Your employment will be effective, as of <b>' . date('d F Y', strtotime($userData->created_at)) . '</b></td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left"><b>2. Job title</b></td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">Your job title will be Sales Consultant, and you will report to -.</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left"><b>3. Probation</b></td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">You will be on probation for three months, after which you will be made permanent subject to the company’s satisfaction with your performance, suitability, and capability and this will be communicated to you in writing.</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left"><b>4. CTC and salary breakup</b></td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">Your monthly Gross Salary will be ' . number_format($userData->salary, 2) . ' INR and your salary breakup are 

below</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">It is agreed that the company may from time to time add, modify or repeal any 

remuneration, benefit, facility that may have been extended to you on a review of the organization’s functioning, finances and prospects and you shall be bound by the organization’s decisions on this behalf</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">Any statutory deductions (PF, ESI, TDS etc.) will be made as per the laws 

applicable</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">211, second floor, Vaishali Tower 1st, Nursery Circle, Jaipur, Rajasthan-302021 - 

Phone No.- 7014526403</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left"><b>5. Place of posting</b></td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">You will be posted at Jaipur, Rajasthan. You may however be required to work at 

any place of business which the Company has, or may later acquire.</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left"><b>6. Hours of Work</b></td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">You are scheduled to work through Monday to Sunday, plus any reasonable 

additional hours that are necessary to fulfil your duties or as otherwise required by the employer. The company provides you 1 week off. The company reserves 

the right to adjust your shift times based on business needs.</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left"><b>7. Nature of duties</b></td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">You will perform to the best of your ability all the duties as are inherent in your 

post and such additional duties as the company may call upon you to perform, from time to time. Your specific duties are set out in Annexure A hereto.</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left"><b>8. Company property</b></td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">You will always maintain in good condition Company property, which may be entrusted to you for official use during the course of your employment and shall return all such property to the Company prior to relinquishment of your charge, failing which the cost of the same will be recovered from you by the Company.</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left"><b>9. Borrowing/accepting gifts</b></td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">You will not borrow or accept any money, gift, reward or compensation for your personal gains from or otherwise place yourself under pecuniary obligation to any person/client with whom you may be having official dealings.</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left"><b>10. Termination</b></td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">10.1 Your appointment can be terminated by the Company, without any reason, by giving you not less than one months’ prior notice in writing or salary in lieu thereof. For the purpose of this clause, salary shall mean basic salary.</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">10.2 If you want to terminate your employment with the Company before 1 years from starting of your employment, you should give no less than 30 days’ prior notice or one month’s salary and incentive in lieu of notice.</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">If you want to terminate your employment with the Company after 1 years from starting of your employment, you should give no less than 30 days’ prior notice or one months’ salary and incentive in lieu of notice.</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">211, second floor, Vaishali Tower 1st, Nursery Circle, Jaipur, Rajasthan-302021 - 

Phone No.- 7014526403</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">10.3 The Company reserves the right to terminate your employment summarily without any notice period or termination payment, if it has reasonable ground to believe you are guilty of misconduct or negligence or have consistently shown poor work performance or have committed any fundamental breach of contract or violated company policy or caused any loss to the Company.</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">10.4 On the termination of your employment for whatever reason, you will return to the Company all property; documents and paper, both original and copies thereof, including any samples, literature, contracts, records, lists, drawings, blueprints, letters, notes, data and the like; and Confidential Information, in your possession or under your control relating to your employment or to clients’ business affairs. In case of any failure in returning the Company property or loss or damage of any extent whatsoever to any property while it is in your possession, you will be liable to pay amount equivalent to the property or the cost incurred in repair/replacement of that property.If any employee forgoes the joining fee from the customer, then you will be fined Rs.500 as a penalty</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left"><b>11. Confidential Information</b></td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">11.1 During your employment with the Company you will devote your whole time, attention and skill to the best of your ability for its business. You shall not, directly or indirectly, engage or associate yourself with, be connected with, concerned, employed or engaged in any other business or activities or any other post or work part-time or pursue any course of study whatsoever, without the prior permission of the Company</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">11.2 You must always maintain the highest degree of confidentiality and keep 

as confidential the records, documents and other Confidential Information relating to the business of the Company which may be known to you or confided in you by any means and you will use such records, documents and information only in a duly authorized manner in the interest of the Company. For the purposes of this clause ‘Confidential Information’ means information about the Company’s business and that of its customers which is not available to the general public and which may be learnt by you in the course of your employment. This includes, but is not limited to, information relating to the organization, its customer lists, employment policies, personnel, and information about the Company’s products, processes including ideas, concepts, projections, technology, manuals, drawing, designs, specifications, and all papers, resumes, records and other documents containing such Confidential Information.</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">11.3 At no time, will you remove any Confidential Information from the office 

without permission</td></tr>';        
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">211, second floor, Vaishali Tower 1st, Nursery Circle, Jaipur, Rajasthan-302021 - 

Phone No.- 7014526403</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">11.4 Your duty to safeguard and not disclose Confidential Information will survive the expiration or termination of this Agreement and/or your employment with the Company.</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">11.5 Breach of the conditions of this clause will render you liable to summary dismissal under clause above in addition to any other remedy the Company may have against you in law.</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left"><b>12. Notices</b></td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">Notices may be given by you to the Company at its registered office address. Notices may be given by the Company to you at the address intimated by you in the official records</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left"><b>13. Applicability of Company Policy</b></td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">The Company shall be entitled to make policy declarations from time to time pertaining to matters like code of conduct, leave entitlement, maternity leave, employees’ benefits, working hours, transfer policies, etc., and may alter the same from time to time at its sole discretion. All such policy decisions of the Company shall be binding on you and shall override this Agreement to that extent</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left"><b>14. Governing Law/Jurisdiction</b></td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">Your employment with the Company is subject to Indian laws. All disputes shall 

be subject to the jurisdiction of Jaipur only.</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left"><b>15. Acceptance of our offer</b></td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">Please confirm your acceptance of this Contract of Employment by signing and returning the duplicate copy. We welcome you, and look forward to receiving your acceptance and to working with you</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">Yours Sincerely,</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">Team: - Human Resources</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px;" colspan="6" align="left">Note: You will receive a salary, and all other benefits forming part of your remuneration package subject to, and after, deduction of tax at source in accordance with applicable law.</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '<tr><td style="padding:5px; font-family:tahoma;font-size:21px" colspan="6" align="center"><strong>CTC STRUCTURE</strong></td></tr>';
        $html.= '<tr><td>&nbsp;</td></tr>';
        $html.= '</table>';
        $html.= '<table style="width:100%; border: 1px solid;">';
        $html.= '<tr style="border: 1px solid #dddddd;">';
        $html.= '<td style="border-right: 1px solid;"><b>NAME: '.$userData->name.'</b></td>';
        $html.= '<td><b>DESIGNATION: </b></td>';
        $html.= '</tr>';
        $html.= '<tr>';
        $html.= '<td style="border-top: 1px solid;border-right: 1px solid;"><b>COMPONENTS</b></td>';
        $html.= '<td style="border-top: 1px solid;"><b>MONTHLY </b></td>';
        $html.= '</tr>';
        $html.= '<tr>';
        $basic = ($userData->salary * 50) / 100;
        $html.= '<td style="border-top: 1px solid;border-right: 1px solid;">Basic</td>';
        $html.= '<td style="border-top: 1px solid;">' .$basic. ' INR</td>';
        $html.= '</tr>';
        $html.= '<tr>';
        $html.= '<td style="border-top: 1px solid;border-right: 1px solid;">HRA</td>';
        $html.= '<td style="border-top: 1px solid;">' . ($basic * 40) / 100 . ' INR</td>';
        $html.= '</tr>';
        $html.= '<tr>';
        $html.= '<td style="border-top: 1px solid;border-right: 1px solid;">Special Allowances</td>';
        $html.= '<td style="border-top: 1px solid;">' . ($basic * 60) / 100 . ' INR</td>';
        $html.= '</tr>';
        $html.= '<tr>';
        $html.= '<td style="border-top: 1px solid;border-right: 1px solid;"><b>TC</b></td>';
        $html.= '<td style="border-top: 1px solid;"><b>' . $userData->salary . ' INR</b></td>';
        $html.= '</tr>';
        $html.= '</table>';
        $fileName = 'offer_letter.pdf';
        $mypdf = new mPDF(['margin_left' => 5, 'margin_right' => 5, 'margin_top' => 5, 'margin_bottom' => 5, 'margin_header' => 1, 'margin_footer' => 1, ]);
        $mypdf->SetDisplayMode('fullpage');
        $mypdf->WriteHTML($html);
        $storage_path = storage_path();
        $structure = $storage_path . "/pdf/";
        $file_name = $structure . $fileName;
        $mypdf->Output($file_name);
        echo env('APP_URL') . 'storage/pdf/' . $fileName;
        echo 'Success';
        die;
    }
}
