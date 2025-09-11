@if($records->count()>0)

    @foreach($records as $key => $row)

    <tr>

        <td>

            <div class="d-flex align-items-center">

                {!! $row->year !!}

            </div>

        </td>


        <td>

            <div class="d-flex align-items-center">

                {!! date("F", mktime(0, 0, 0, $row->month, 10)) !!}

            </div>

        </td>

        <td>

            <div class="d-flex align-items-center">

                {{ cal_days_in_month(CAL_GREGORIAN, $row->month, $row->year) }}

            </div>

        </td>


        <td>

            <div class="d-flex align-items-center">

                @php $total_days = cal_days_in_month(CAL_GREGORIAN, $row->month, $row->year); @endphp

                <input type="text" name="total_leave" style="width:100px; text-align:center;" id="total_leave" onchange="updateTotalLeave('{{$row->id}}','{{$total_days}}',this.value)" class="form-control numberonly" maxlength="2" value="{{ $row->total_leave }}"/>

            </div>

        </td>

        <td>

            <div class="d-flex align-items-center">

                @php
                    
                    echo $total_days - $row->total_leave;
                @endphp

            </div>

        </td>


        

        <td>

            <a href="javascript:void(0)" onclick="getPayaslip('{!! $row->month !!}','{!! $row->year !!}')" class="btn btn-sm btn-primary" title="View Payslip">

                View Payslip

            </a>            

        </td>

    </tr>

    @endforeach

    @else

    <tr>

        <td align="center" colspan="9">Record not found</td>

    </tr>

    @endif

    <tr>

        <td align="center" colspan="9">

            <div id="pagination">{{ $records->appends(request()->except('page'))->links('vendor.pagination.custom') }}</div>

        </td>

    </tr>

    <script>
        $(document).ready(function () {
            $('.numberonly').keypress(function(e){
                var charCode = (e.which) ? e.which : event.keyCode
                if(String.fromCharCode(charCode).match(/[^0-9+]/g))
                return false;
            });
        });
    </script>