<?php
namespace App\Helpers;
use DB;
use Session;
class Helper {

    public static function getTotalCustomer($type = NULL) {
        $query = DB::table('users');
        $query->where('status', 1);
        if ($type != NULL) {
            $query->where('type', $type);
        }
        $records = $query->count();
        return $records;
    }

    public static function getProductInfo($id) {
        $records = DB::table('products')->where(array('id' => $id))->first();
        return $records;
    }

    public static function getUserInfo($id) {
        if ($id > 0) {
            $records = DB::table('users')->where(array('id' => $id))->first();
            return $records;
        } else {
            return 'Admin';
        }
    }

    public static function getUserName($id) {
        if ($id > 0) {
            $records = DB::table('users')->where(array('id' => $id))->first();
            return $records->name;
        } else {
            return 'Admin';
        }
    }

    public static function checkTodayAttendence($emp_id = NULL) {
        $record = '';
        if ($emp_id != '') {
            $date = date('Y-m-d');
            $record = DB::table('attendence')->where('employee_id', $emp_id)->where('date', $date)->where('status', '!=', 3)->first();
        }
        return $record;
    }

    public static function getTotalPresent($emp_id = NULL, $month = NULL, $year = NULL) {
        $record = 0;
        if ($emp_id != '' && $month != '' && $year != '') {
            $record = DB::table('attendence')->where('employee_id', $emp_id)->where('month', $month)->where('year', $year)->where('in_status', 'Present')->where('status', '!=', 3)->count();
        }
        return $record;
    }

    public static function getTotalAbsent($emp_id = NULL, $month = NULL, $year = NULL) {
        $count = 0;
        if ($emp_id != '' && $month != '' && $year != '') {
            $count_absent = DB::table('attendence')->where('employee_id', $emp_id)->where('month', $month)->where('year', $year)->where('in_status', 'Absent')->where('status', '!=', 3)->count();
            $count_half_day = DB::table('attendence')->where('employee_id', $emp_id)->where('month', $month)->where('year', $year)->where('in_status', 'Half Day')->where('status', '!=', 3)->count();
            if ($count_half_day > 0) {
                if ($count_half_day % 2 != 0) {
                    $count_half_day = $count_half_day - 1;
                }
            }
            $count = $count_absent + $count_half_day;
        }
        return $count;
    }

    public static function getTotalSalary($emp_id = NULL, $month = NULL, $year = NULL){
        $total_salary = 0;
        if($emp_id != '' && $month != '' && $year != ''){
            $payslip = DB::table('payslips')->where('month', $month)->where('year', $year)->first();
            $user = DB::table('users')->where('id', $emp_id)->where('status', 1)->first();
            if(isset($user->id)){
                $salary = $user->salary;
                ###################
                $sundays = 0;
                $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                for($i = 1;$i <= $days;$i++){
                    if(date('N', strtotime($year . '-' . $month . '-' . $i)) == 7){
                        $sundays++;
                    }
                }
                if(isset($payslip->id)){
                    $sundays = $payslip->total_leave;
                }                
                ###################
                if($salary > 0){
                    $days = $days - $sundays;
                    if($days > 0){
                        $one_day_salary = round($salary / $days);
                        $total_present = Helper::getTotalPresent($emp_id, $month, $year);
                        if ($total_present > 0) {
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

    public static function getTotalAdvance($emp_id = NULL, $month = NULL, $year = NULL) {
        $sum = $installment_amt = $advance_amt = 0;
        if ($emp_id != '' && $month != '' && $year != '') {
            $all_advance = DB::table('advance')->where('user_id', $emp_id)->where('month', $month)->where('year', $year)->where('status', 1)->get();
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

    public static function getTotalIncentive($emp_id = NULL, $month = NULL, $year = NULL) {
        $total = 0;
        if ($emp_id != '' && $month != '' && $year != ''){
            $incentive = DB::table('incentives')->where('emp_id', $emp_id)->where('month', $month)->where('year', $year)->where('status', 1)->first();
            if (isset($incentive->id)) {
                $total = $incentive->amount;
            }
        }
        return $total;
    }

    public static function getTodayPresent() {
        $today_date = date('Y-m-d');
        $month = date('m');
        $year = date('Y');
        $day = date('d');
        return DB::table('attendence')->where('day', $day)->where('month', $month)->where('year', $year)->where('in_status', 'Present')->where('status', '!=', 3)->count();
    }
}
?>