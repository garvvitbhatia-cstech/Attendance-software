<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Advance;
use App\Models\Enquiries;
use App\Models\Payslips;
use App\Models\User;
use App\Models\EmployeeAttendence;
use App\Models\Incentives;
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
use App\Http\Controllers\Admin\GeneralController;

class ExportController extends Controller {
    private static $Enquiries;
    private static $Advance;
    private static $EmployeeAttendence;
    private static $Incentives;
    private static $Payslips;
    private static $Users;

    public function __construct() {
        self::$Enquiries = new Enquiries();
        self::$Advance = new Advance();
        self::$Incentives = new Incentives();
        self::$EmployeeAttendence = new EmployeeAttendence();
        self::$Payslips = new Payslips();
        self::$Users = new User();
    }

    #exportIncentive
    public function exportIncentive(Request $request) {
        if (!$request->session()->has('admin_email')) {
            echo 'SessionExpired';
            die;
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
        $records = $query->orderBy('id', 'DESC')->get();
        $delimiter = ",";
        $filename = "incentive_" . date('d_F_Y') . ".csv";
        $destination = "storage/csv/" . $filename;
        //create a file pointer
        $f = fopen($destination, "w");
        //set column headers
        $fields = array(
            'S.No', 
            'Employee ID', 
            'Employee Name', 
            'Date', 
            'Amount', 
            'Created'
        );
        fputcsv($f, $fields, $delimiter);
        foreach ($records as $key => $record):
            $user = $this->getUser($record->emp_id);
            $status = $record->in_status;
            $lineData = array(
                $key + 1, 
                $user->emp_id, 
                $user->name, 
                $record->incentive_date, 
                $record->amount, 
                $record->created_at
            );
            fputcsv($f, $lineData, $delimiter);
        endforeach;
        $lineData2 = array('', '');
        fputcsv($f, $lineData2, $delimiter);
        fclose($f);
        echo env('APP_URL') . $destination;
        exit;
    }

    public function exportEmployee(Request $request) {
        if (!$request->session()->has('admin_email')) {
            echo 'SessionExpired';
            die;
        }
        $query = self::$Users->where('status', '!=', 3)->where('type', 'Employee');
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
        $records = $query->orderBy('id', 'DESC')->get();
        $delimiter = ",";
        $filename = "employee_" . date('d_F_Y') . ".csv";
        $destination = "storage/csv/" . $filename;
        //create a file pointer
        $f = fopen($destination, "w");
        //set column headers
        $fields = array(
            'S.No', 
            'Employee ID', 
            'Employee Name', 
            'Email', 
            'Password', 
            'Salary', 
            'Father Name',
            'Correspondence Address', 
            'DOB', 
            'Marital Status', 
            'Address', 'Latitude',
            'Longitude', 'Mobile', 
            'Telephone', 'PAN Card', 
            'Blood Group', 
            'Emergency Contact Name', 
            'Emergency Contact Relation', 
            'Emergency Contact Mobile', 
            'Education Degree', 
            'Education University', 
            'Education From Date', 
            'Education To Date', 
            'Education Percentage', 
            'Education Specialisation', 
            'Employee Organisation', 
            'Employee Designation', 
            'Employee From Service Period', 
            'Employee To Service Period', 
            'Employee CTC', 'Family Name', 
            'Family Relation', 
            'Family Occupation', 
            'Family DOB', 
            'Account Number', 
            'IFSC', 
            'Bank Name', 
            'Account Holder Name', 
            'Professional Name', 
            'Professional Organization', 
            'Professional Contact', 
            'Created'
        );
        fputcsv($f, $fields, $delimiter);
        foreach ($records as $key => $record):
            $lineData = array(
                $key + 1, 
                $record->emp_id, 
                $record->name, 
                $record->email, 
                $this->decryptData($record->temp_password), 
                $record->salary, 
                $record->father_name,
                $record->correspondence_address, 
                $record->dob, 
                $record->marital_status, 
                $record->permanent_address, 
                $record->latitude, 
                $record->longitude, 
                $record->mobile, 
                $record->telephone, 
                $record->pan_card, 
                $record->blood_group, 
                $record->emergency_name, 
                $record->emergency_relation, 
                $record->emergency_contact, 
                str_replace('|', ', ', $record->education_degree), 
                str_replace('|', ', ', $record->education_university), 
                str_replace('|', ', ', $record->education_from), 
                str_replace('|', ', ', $record->education_to), 
                str_replace('|', ', ', $record->education_percentage), 
                str_replace('|', ', ', $record->education_specialization), 
                str_replace('|', ', ', $record->employee_organisation),
                str_replace('|', ', ', $record->employee_designation), 
                str_replace('|', ', ', $record->employee_from_service_period), 
                str_replace('|', ', ', $record->employee_to_service_period), 
                str_replace('|', ', ', $record->employee_ctc), 
                str_replace('|', ', ', $record->family_name), 
                str_replace('|', ', ', $record->family_relation), 
                str_replace('|', ', ', $record->family_occupation), 
                str_replace('|', ', ', $record->family_dob), 
                $record->account_no, 
                $record->ifsc, 
                $record->bank_name, 
                $record->account_holder_name, 
                str_replace('|', ', ', $record->professional_name), 
                str_replace('|', ', ', $record->professional_organisation), 
                str_replace('|', ', ', $record->professional_contact), 
                $record->created_at
            );
            fputcsv($f, $lineData, $delimiter);
        endforeach;
        $lineData2 = array('', '');
        fputcsv($f, $lineData2, $delimiter);
        fclose($f);
        echo env('APP_URL') . $destination;
        exit;
    }

    #exportProduct
    public function exportEmployeeAttendance(Request $request) {
        if (!$request->session()->has('admin_email')) {
            echo 'SessionExpired';
            die;
        }
        $query = self::$EmployeeAttendence->where('status', '!=', 3);
        if ($request->session()->get('admin_id') > 1 && $request->session()->get('admin_type') == 'Employee') {
            $query->where('employee_id', $request->session()->get('admin_id'));
        }
        if ($request->input('day') && $request->input('day') != "") {
            $day = $request->input('day');
            $query->where('day', $day);
        }
        if ($request->input('month') && $request->input('month') != "") {
            $month = $request->input('month');
            $query->where('month', $month);
        }
        if ($request->input('in_status') && $request->input('in_status') != "") {
            $in_status = $request->input('in_status');
            $query->where('in_status', $in_status);
        }
        if ($request->input('year') && $request->input('year') != "") {
            $year = $request->input('year');
            $query->where('year', $year);
        }
        if ($request->input('name') && $request->input('name') != "") {
            $name = $request->input('name');
            $data = DB::table('users')->where('name', 'like', '%' . $name . '%')->where('status', '!=', 3)->get();
            foreach ($data as $key => $value) {
                if (isset($value->id)) {
                    $setDatas[] = $value->id;
                }
            }
            $implode = implode(',', array_unique($setDatas));
            $query->whereRaw('FIND_IN_SET(employee_id, ?)', [$implode]);
        }
        if ($request->input('employee_id') && $request->input('employee_id') != "") {
            $employee_id = $request->input('employee_id');
            $data = DB::table('users')->where('emp_id', 'like', '%' . $employee_id . '%')->where('status', '!=', 3)->get();
            foreach ($data as $key => $value) {
                if (isset($value->id)) {
                    $setDatas[] = $value->id;
                }
            }
            $implode = implode(',', array_unique($setDatas));
            $query->whereRaw('FIND_IN_SET(employee_id, ?)', [$implode]);
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
                $query->where('date', '>=', $fdate);
            } else if (empty($fdate) && !empty($tdate)) {
                $query->where('date', '<=', $tdate);
            } else {
                $query->whereBetween(DB::raw('DATE(date)'), [$fdate, $tdate]);
            }
        }
        $records = $query->orderBy('id', 'DESC')->get();
        $delimiter = ",";
        $filename = "attendance_" . date('d_F_Y') . ".csv";
        $destination = "storage/csv/" . $filename;
        //create a file pointer
        $f = fopen($destination, "w");
        //set column headers
        $fields = array(
            'S.No', 
            'Employee ID', 
            'Employee Name', 
            'Latitude', 
            'Longitude', 
            'Date', 
            'Check IN', 
            'Check OUT', 
            'Status', 
            'Note', 
            'Created'
        );
        fputcsv($f, $fields, $delimiter);
        foreach ($records as $key => $record):
            $user = $this->getUser($record->employee_id);
            $status = $record->in_status;
            $lineData = array(
                $key + 1,
                $user->emp_id, 
                $user->name, 
                $record->latitude, 
                $record->longitude, 
                $record->date, 
                $record->check_in, 
                $record->check_out, 
                $status, 
                $record->message, 
                $record->created_at
            );
            fputcsv($f, $lineData, $delimiter);
        endforeach;
        $lineData2 = array('', '');
        fputcsv($f, $lineData2, $delimiter);
        fclose($f);
        echo env('APP_URL') . $destination;
        exit;
    }

    #exportProduct
    public function exportEnquiries(Request $request) {
        if (!$request->session()->has('admin_email')) {
            echo 'SessionExpired';
            die;
        }
        $query = self::$Enquiries->where('status', '!=', 3);
        if ($request->input('name') && $request->input('name') != "") {
            $SearchKeyword = $request->input('name');
            $query->where('name', 'like', '%' . $SearchKeyword . '%');
        }
        if ($request->input('read_status') && $request->input('read_status') != "") {
            $SearchKeyword = $request->input('read_status');
            $query->where('read_status', 'like', '%' . $SearchKeyword . '%');
        }
        $records = $query->orderBy('id', 'DESC')->get();
        $delimiter = ",";
        $filename = "enquiries_" . date('d_F_Y') . ".csv";
        $destination = "storage/csv/" . $filename;
        //create a file pointer
        $f = fopen($destination, "w");
        //set column headers
        $fields = array(
            'S.No', 
            'Name', 
            'email', 
            'Phone', 
            'Subject', 
            'Message', 
            'Status', 
            'Created'
        );
        fputcsv($f, $fields, $delimiter);
        foreach ($records as $key => $record):
            $status = '';
            if ($record->read_status == 1) {
                $status = 'Read';
            }
            if ($record->read_status == 2) {
                $status = 'Unread';
            }
            $lineData = array(
                $key + 1, 
                $record->name,
                $record->email, 
                $record->contact, 
                $record->subject, 
                $record->message, 
                $status, 
                $record->created_at
            );
            fputcsv($f, $lineData, $delimiter);
        endforeach;
        $lineData2 = array('', '');
        fputcsv($f, $lineData2, $delimiter);
        fclose($f);
        echo env('APP_URL') . $destination;
        exit;
    }

    #exportPayslip
    public function exportPayslip(Request $request) {
        if (!$request->session()->has('admin_email')) {
            echo 'SessionExpired';
            die;
        }
        $month = $request->input('month');
        $year = $request->input('year');
        $records = self::$Users->where('type', 'Employee')->where('status', 1)->orderBy('name', 'ASC')->get();
        $delimiter = ",";
        $filename = "employee_payslip_" . date('d_F_Y') . ".csv";
        $destination = "storage/csv/" . $filename;
        //create a file pointer
        $f = fopen($destination, "w");
        //set column headers
        $fields = array(
            'S.No', 
            'Date', 
            'Name', 
            'Code', 
            'Present', 
            'Salary'
        );
        fputcsv($f, $fields, $delimiter);
        foreach ($records as $key => $record):
            $present = $this->getTotalPresent($record->id, $month, $year);
            $salary = $this->getTotalSalary($record->id, $month, $year);
            $total_incentive = 0;
            if ($month != '') {
                $nyear = $year;
                $nmonth = $month - 1;
                if ($nmonth == 0) {
                    $nmonth = 12;
                    $nyear = $year - 1;
                }
                if($present > 0){
                    $total_incentive = $this->getTotalIncentive($record->id, $nmonth, $nyear);
                }
            }
            $final_salary = $salary + $total_incentive;
            $tds = (1 / 100) * $final_salary;
            $round_amt = round($final_salary - $tds);
            $final_salary = $round_amt;
            $lineData = array(
                $key + 1, 
                $month . '-' . $year, 
                $record->name, 
                $record->emp_id, 
                $present, $final_salary
            );
            fputcsv($f, $lineData, $delimiter);
        endforeach;
        $lineData2 = array('', '');
        fputcsv($f, $lineData2, $delimiter);
        fclose($f);
        echo env('APP_URL') . $destination;
        exit;
    }

    public function getUser($uid) {
        return self::$Users->where('id', $uid)->first();
    }

    public function getTotalIncentive($emp_id = NULL, $month = NULL, $year = NULL) {
        $total = 0;
        if ($emp_id != '' && $month != '' && $year != '') {
            $incentive = self::$Incentives->where('emp_id', $emp_id)->where('month', $month)->where('year', $year)->where('status', 1)->first();
            if(isset($incentive->id)){
                $total = $incentive->amount;
            }
        }
        return $total;
    }

    public function getTotalPresent($emp_id = NULL, $month = NULL, $year = NULL) {
        $record = 0;
        if ($emp_id != '' && $month != '' && $year != '') {
            $record = self::$EmployeeAttendence->where('employee_id', $emp_id)->where('month', $month)->where('year', $year)->where('in_status', 'Present')->where('status', '!=', 3)->count();
        }
        return $record;
    }

    public function getTotalAdvance($emp_id = NULL, $month = NULL, $year = NULL) {
        $sum = $installment_amt = $advance_amt = 0;
        if ($emp_id != '' && $month != '' && $year != '') {
            $all_advance = self::$Advance->where('user_id', $emp_id)->where('month', $month)->where('year', $year)->where('status', 1)->get();
            if ($all_advance->count() > 0) {
                foreach ($all_advance as $key => $advance) {
                    if ($advance->mode == 'Installment') {
                        $installment_amt+= $advance->installment;
                    } else {
                        $advance_amt+= $advance->amount;
                    }
                }
                $sum = $installment_amt + $advance_amt;
            }
        }
        return array('installment' => $installment_amt, 'advance' => $advance_amt);
    }

    public function getTotalSalary($emp_id = NULL, $month = NULL, $year = NULL) {
        $total_salary = 0;
        if ($emp_id != '' && $month != '' && $year != '') {
            $user = self::$Users->where('id', $emp_id)->where('status', 1)->first();
            $payslip = self::$Payslips->where('month', $month)->where('year', $year)->first();
            if (isset($user->id)) {
                $salary = $user->salary;
                ###################
                $sundays = 0;
                $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                for ($i = 1;$i <= $days;$i++){
                    if (date('N', strtotime($year . '-' . $month . '-' . $i)) == 7){
                        $sundays++;
                    }
                }
                if(isset($payslip->id)){
                    $sundays = $payslip->total_leave;
                }
                ###################
                if ($salary > 0) {
                    $days = $days - $sundays;
                    if($days > 0){
                        $one_day_salary = round($salary / $days);
                        $total_present = $this->getTotalPresent($emp_id, $month, $year);
                        if ($total_present > 0) {
                            if($total_present > $days){
                                $total_present = $days;
                            }
                            //$advance = $this->getTotalAdvance($emp_id, $month, $year);
                            $total = 0;//$advance['installment'] + $advance['advance'];
                            $total_salary = ($one_day_salary * $total_present) - $total;
                        }
                    }
                }
            }
        }
        return $total_salary;
    }
}
