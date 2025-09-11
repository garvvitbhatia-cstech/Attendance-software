<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Payslips;
use App\Models\Settings;
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
use Mpdf\Mpdf;

class PayslipsController extends Controller {
    private static $Payslips;
    private static $User;
    private static $Settings;
    
    public function __construct() {
        self::$Payslips = new Payslips();
        self::$User = new User();
        self::$Settings = new Settings();
    }

    #admin dashboard page
    public function getList(Request $request) {
        if(!$request->session()->has('admin_email')){
            return redirect('/admin/');
        }
        if($request->session()->get('admin_type')){
            if ($request->session()->get('admin_type') == 'Employee'){
                return redirect('/admin/');
            }
        }
        $setting = self::$Settings->where('id',1)->first();
        $year = date('Y');
        $month = date('m');
        $count = self::$Payslips->where('month', $month)->where('year', $year)->where('status', '!=', 3)->count();
        if ($count == 0) {
            if($setting->id){
                $setData['total_leave'] = $setting->holiyday_allowed;
            }
            $setData['month'] = $month;
            $setData['year'] = $year;            
            $record = self::$Payslips->CreateRecord($setData);
        }
        return view('/admin/payslips/index');
    }

    public function listPaginate(Request $request) {
        if (!$request->session()->has('admin_email')) {
            return redirect('/admin/');
        }
        $query = self::$Payslips->where('status', '!=', 3);
        if ($request->input('month') && $request->input('month') != "") {
            $month = $request->input('month');
            $query->where('month', $month);
        }
        if ($request->input('year') && $request->input('year') != "") {
            $year = $request->input('year');
            $query->where('year', $year);
        }
        $records = $query->orderBy('id', 'DESC')->paginate(20);
        return view('/admin/payslips/paginate', compact('records'));
    }

    public function getCurrentPayslip(Request $request) {
        if (!$request->session()->has('admin_email')) {
            return redirect('/admin/');
        }
        if ($request->session()->get('admin_type')) {
            if ($request->session()->get('admin_type') == 'Employee') {
                return redirect('/admin/');
            }
        }
        if ($request->ajax()) {
            $month = $request->input('month');
            $year = $request->input('year');
            $employee = self::$User->where('type', 'Employee')->where('status', 1)->orderBy('name')->get();
            echo view('/admin/payslips/get_current_payslip', compact('month', 'year', 'employee'));
        }
        exit;
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

    public function generateEmployeePayslip(Request $request){
        $year = $request->year;
        $month = $request->month;
        $row_id = base64_decode($request->rowID);
		$userData = self::$User->where('id',$row_id)->first();	
        $payslip = self::$Payslips->where('month', $month)->where('year', $year)->first();
        $total_present = $this->getTotalPresent($userData->id, $month, $year);
        $total_incentive = 0;
        if($month != ''){
            $nyear = $year;
            $nmonth = $month-1;
            if($nmonth == 0){
                $nmonth = 12;        
                $nyear = $year-1;
            }
            if($total_present > 0){
                $total_incentive = $this->getTotalIncentive($userData->id,$nmonth,$nyear);
            }
        }		
        $currmnth = $month;
        $curryear = $year;
        $destination = base_path() . '/public/img/logo/logo.png';
		$html = '<table class="table" cellspacing="0" width="100%">';
        $html .= '<tr>';
        $html .= '<td style="border-top:1px solid #000;border-left:1px solid #000;padding:5px; font-family:tahoma;" colspan="1" align="left">';
        $html .= '<img src=' . $destination . ' style="max-width:100px;height: auto;margin-top:0;padding-top:0">';
        $html .= '</td>';
        $html .= '<td style="border-top:1px solid #000;border-right:1px solid #000;padding:5px; font-family:tahoma;" colspan="5" align="center"><span style="font-size:22px;">KAUSHAL ENTERPRISES</span><br><br>
              <span>Office No. 211, 2nd Floor, Vaishali Tower-1, Nursery Circle, Jaipur, Rajasthan - 302021</span><br />
              <span><strong>Payslip for the month of '.strftime('%B', mktime(0, 0, 0, $month, 1)).' '.$year.'</strong><span><br /><br><br /></td>';
        $html .= '</tr>';
        
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $sundays = 0;
        for ($i = 1;$i <= $days;$i++) {
            if (date('N', strtotime($year . '-' . $month . '-' . $i)) == 7) {
                $sundays++;
            }
        }
        if(isset($payslip->id)){
            $sundays = $payslip->total_leave;
        } 
        $total_days = $days - $sundays;
        if($total_present > 0){
            if($total_present > $total_days){
                $total_present = $total_days;
            }
        }
        $html .='<tr>
              <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;border-right:1px solid #000; padding:5px; font-family:tahoma;" valign="top" colspan="3" align="left">
              <span> <strong>Name: </strong>'.ucwords($userData->name).'</span><br />
              <span> <strong>Joining Date: </strong>'.date('d-m-Y',strtotime($userData->created_at)).'</span><br />
              <span> <strong>Designation: </strong>Sales Associate</span><br />
              <span> <strong>Department: </strong>Sales</span><br />
              <span> <strong>Location: </strong>Jaipur</span><br />
              <span> <strong>Effective Work Days: </strong>'.$total_present.'</span><br />
              <span> <strong>LOP: </strong>'.$total_days-$total_present.'</span><br />
              </td>
              <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000; padding:5px; font-family:tahoma;" valign="top" colspan="3" align="left">
              <span><strong>Employee No: </strong>'.$userData->emp_id.'</span><br />
              <span><strong>Bank Name: </strong>'.$userData->bank_name.'</span><br />
              <span><strong>Account No: </strong>'.$userData->account_no.'</span><br />
              <span><strong>PAN No: </strong>'.$userData->pan_card.'</span><br />
              <span><strong>PF No: </strong></span><br />
              <span><strong>PF UAN: </strong></span><br />
              </td>
              </tr>';
			  
			  $html .='<tr>
			  <td style="border-left:1px solid #000;border-bottom:1px solid #000; padding:5px; font-family:tahoma;" align="center"><strong>Earnings</strong></td>
              <td style="border-left:1px solid #000;border-bottom:1px solid #000; padding:5px; font-family:tahoma;" align="center"><strong>Master</strong></td>
              <td style="border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000; padding:5px; font-family:tahoma;" align="center"><strong>Actual</strong></td>
              
			  <td style="border-bottom:1px solid #000;padding:0px; font-family:tahoma;" align="center"><strong>Deduction</strong></td>
              <td style="border-bottom:1px solid #000; padding:0px; font-family:tahoma;" align="center"><strong></strong></td>
              <td style="border-bottom:1px solid #000;border-left:1px solid #000;border-right:1px solid #000; padding:0px; font-family:tahoma;" align="center"><strong>Actual</strong></td>
              </tr>';
                $total_salary = $this->getTotalSalary($userData->id, $month, $year);                
                $final_salary = $total_salary + $total_incentive;
                $tds = (1 / 100) * $final_salary;
                $round_amt = round($final_salary-$tds);
                $final_salary = $round_amt;

                $total_earnings = $total_salary;
                $actual_basic = ($total_earnings * 50)/100;
                $actual_hra = ($actual_basic * 40)/100;
                $actual_sa = ($actual_basic * 60)/100;
                
              $basic = ($userData->salary * 50)/100;

              $html .='<tr>
              <td style="border-left:1px solid #000;border-bottom:1px solid #000; padding:5px; font-family:tahoma;" align="center">Basic</td>
              <td style="border-left:1px solid #000;border-bottom:1px solid #000; padding:5px; font-family:tahoma;" align="center">'.$basic.'</td>
              <td style="border-left:1px solid #000;border-bottom:1px solid #000; padding:5px; font-family:tahoma;" align="center">'.$actual_basic.'</td>

              <td colspan="2" style="border-left:1px solid #000;border-bottom:1px solid #000; padding:5px; font-family:tahoma;" align="center">Income Tax</td>
              <td style="border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000; padding:5px; font-family:tahoma;" align="center">'.$tds.'</td>
              </tr>';
                $HRA = ($basic * 40)/100;
              $html .='<tr>
              <td style="border-left:1px solid #000;border-bottom:1px solid #000; padding:5px; font-family:tahoma;" align="center">HRA</td>
              <td style="border-left:1px solid #000;border-bottom:1px solid #000; padding:5px; font-family:tahoma;" align="center">'.$HRA.'</td>
              <td style="border-left:1px solid #000;border-bottom:1px solid #000; padding:5px; font-family:tahoma;" align="center">'.$actual_hra.'</td>

              <td colspan="3" style="border-left:1px solid #000;border-right:1px solid #000; padding:5px; font-family:tahoma;" align="center"></td>
              </tr>';

              $SA = ($basic * 60)/100;
              $html .='<tr>
              <td style="border-left:1px solid #000;border-bottom:1px solid #000; padding:5px; font-family:tahoma;" align="center">Special Allowance</td>
              <td style="border-left:1px solid #000;border-bottom:1px solid #000; padding:5px; font-family:tahoma;" align="center">'.$SA.'</td>
              <td style="border-left:1px solid #000;border-bottom:1px solid #000; padding:5px; font-family:tahoma;" align="center">'.$actual_sa.'</td>

              <td colspan="3" style="border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000; padding:5px; font-family:tahoma;" align="center"></td>
              </tr>';

              $html .='<tr>
              <td style="border-left:1px solid #000;border-bottom:1px solid #000; padding:5px; font-family:tahoma;" align="center">Incentive</td>
              <td style="border-left:1px solid #000;border-bottom:1px solid #000; padding:5px; font-family:tahoma;" align="center">0</td>
              <td style="border-left:1px solid #000;border-bottom:1px solid #000; padding:5px; font-family:tahoma;" align="center">'.$total_incentive.'</td>

              <td colspan="3" style="border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000; padding:5px; font-family:tahoma;" align="center"></td>
              </tr>';
			  
			  $html .='<tr>
              <td height="30" align="center" style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000; font-family:tahoma;"><strong>Total Earnings</strong></td>
              <td style="border-bottom:1px solid #000;border-right:1px solid #000; font-family:tahoma;" align="center"><strong>'.$userData->salary.'</strong></td>
			  <td  style="border-bottom:1px solid #000; font-family:tahoma;" align="center"><strong>'.$total_salary + $total_incentive.'</strong></td>

              <td height="30" colspan="2" align="center" style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000; font-family:tahoma;"><strong>Total Deductions</strong></td>
			  <td style="border-bottom:1px solid #000;border-right:1px solid #000; font-family:tahoma;" align="center"><strong>'.$tds.'</strong></td>
              </tr>';

			  $html .='<tr>
			  <td style="border-bottom:1px solid #000;border-left:1px solid #000;border-right:1px solid #000; padding:5px; font-family:tahoma;" valign="top" colspan="6" align="left">
              <p>Net Pay for the month (Total Earnings - Total Deductions): <b>'.$final_salary.' INR</b></p><br>';
              if($final_salary > 0){
                $rupees = $this->convert_in_words($final_salary);
                $html .= '<p><i>('.$rupees.' Only)</i></p>';
              }
              $html .= '</td>	
              </tr>';
			  
			  $html .='<tr><td style="border-bottom:1px solid #000;border-left:1px solid #000;border-right:1px solid #000; padding:5px; font-family:tahoma;" colspan="6" align="center">This is computer generated invoice hence no signature required.</td></tr>';
			  
			  
		$html .='</table>';
		
		$fileName = 'payslip.pdf';
		$mypdf = new mPDF([
			'margin_left' => 5,
			'margin_right' => 5,
			'margin_top' => 5,
			'margin_bottom' => 5,
			'margin_header' => 1,
			'margin_footer' => 1,
		]);
		$mypdf->SetDisplayMode('fullpage');
		$mypdf->WriteHTML($html);
		$storage_path = storage_path();
		$structure = $storage_path . "/pdf/";
		$file_name = $structure . $fileName;
		$mypdf->Output($file_name);
		echo env('APP_URL').'storage/pdf/'.$fileName;
		
		echo 'Success'; die;
	}

    public function getTotalSalary($emp_id = NULL, $month = NULL, $year = NULL) {
        $total_salary = 0;
        if ($emp_id != '' && $month != '' && $year != '') {
            $user = DB::table('users')->where('id', $emp_id)->where('status', 1)->first();
            $payslip = DB::table('payslips')->where('month', $month)->where('year', $year)->first();
            if (isset($user->id)) {
                $salary = $user->salary;
                ###################
                $sundays = 0;
                $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                for ($i = 1;$i <= $days;$i++) {
                    if (date('N', strtotime($year . '-' . $month . '-' . $i)) == 7) {
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
                        if($total_present > 0){
                            if($total_present > $days){
                                $total_present = $days;
                            }
                            //$advance = Helper::getTotalAdvance($emp_id, $month, $year);
                            $total = 0; //$advance['installment'] + $advance['advance'];
                            $total_salary = ($one_day_salary * $total_present) - $total;
                        }
                    }
                }
            }
        }
        return $total_salary;
    }

    public function getTotalPresent($emp_id = NULL, $month = NULL, $year = NULL) {
        $record = 0;
        if ($emp_id != '' && $month != '' && $year != '') {            
            $record = DB::table('attendence')->where('employee_id', $emp_id)->where('month', $month)->where('year', $year)->where('in_status', 'Present')->where('status', '!=', 3)->count();
        }
        return $record;
    }

    public function getTotalIncentive($emp_id = NULL, $month = NULL, $year = NULL) {
        $total = 0;
        if ($emp_id != '' && $month != '' && $year != ''){
            $incentive = DB::table('incentives')->where('emp_id', $emp_id)->where('month', $month)->where('year', $year)->where('status', 1)->first();
            if (isset($incentive->id)) {
                $total = $incentive->amount;
            }
        }
        return $total;
    }

    public static function updateTotalLeave(Request $request){
        if($request->ajax()){
            $rowID = $request->rowID;
            $days = $request->days;
            $value = $request->value;
            if($value >= 0 && is_numeric($value) && $value <= $days){
                DB::table('payslips')->where(array('id' => $rowID))->update(array('total_leave' => $value));
            }
            echo "Success";
        }
        exit;
    }

}