@if($month != '' && $year != '')

    @foreach($employee as $key => $user)

    @php
        $total_present = Helper::getTotalPresent($user->id,$month,$year);
        $total_incentive = 0;
        if($month != ''){
            $nyear = $year;
            $nmonth = $month-1;
            if($nmonth == 0){
                $nmonth = 12;
                $nyear = $year-1;
            }
            if($total_present > 0){
                $total_incentive = Helper::getTotalIncentive($user->id,$nmonth,$nyear);
            }
        }        
        $total_absent = Helper::getTotalAbsent($user->id,$month,$year);
        $total_salary = Helper::getTotalSalary($user->id,$month,$year);
        $total_advance = Helper::getTotalAdvance($user->id,$month,$year);
        $total = $total_advance['installment']+$total_advance['advance'];
        $final_salary = $tds = $round_amt = 0;
        if($total_present > 0){
            $final_salarys = $total_salary + $total_incentive;
            $tds = (1 / 100) * $final_salarys;
            $round_amt = round($final_salarys-$tds);
            $final_salary = $round_amt;
        }
    @endphp

        <tr>

            <th scope="row">{{$key+1}}</th>

            <td><a href="javascript:void(0)" onclick="viewDetails('{{$user->id}}')">{{$user->name}} - {{$user->emp_id}}</a></td>

            <td>{{$total_present}}</td>

            <td>{{$total_absent}}</td>

            <td>₹ {{$final_salary}}</td>

            <td>
                <a href="javascript:void(0)" onclick="printPayslip('{{base64_encode($user->id)}}','{{$year}}','{{$month}}')" >View Payslip</a>
            </td>


        </tr>

        <tr class="" id="details_{{$user->id}}" style="display:none;">

        	<td colspan="6">

            	<b>Basic:</b> ₹{{$user->salary}}<br />

                <b>Incentive:</b> ₹{{$total_incentive}}<br>

                <b>TDS:</b> ₹{{$tds}}

            </td>

        </tr>

    @endforeach

@endif