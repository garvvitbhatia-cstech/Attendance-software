@if($records->count()>0)



    @foreach($records as $key => $row)



    @php

    	$count = $records->count();



    	$last = $records->lastItem();



        $page = $records->currentPage();



        $sr = $key+1;



        if($page > 1){



        	$sr = ($last-$count)+$key+1;



        }

    @endphp



    <tr>



        <td>



            <div class="d-flex align-items-center">



                {!! $sr !!}



            </div>



        </td>



        <td>



            <div class="d-flex align-items-center">



                @php



                    $user_info = Helper::getUserInfo($row->employee_id);



                @endphp



                EmployeeID: {{$user_info->emp_id}}<br>



                Name: {{$user_info->name}}<br>



                Latitude: {{ $row->latitude }}<br>



                Longitude: {{ $row->longitude }}



            </div>



        </td>



        <td>



            <div class="d-flex align-items-center">



                {{ date('d-m-Y',strtotime($row->date)) }}


            </div>


        </td>


        <td>


            <div class="d-flex align-items-center">


                @if($row->image != "")

                    @php
                       $dir = $row->year.'/'.$row->month;
                    @endphp

                    <a target="_blank" href="{{ URL::asset('public/admin/images/screenshot/') }}/{{ $dir }}/{{ $row->image }}" data-sub-html="Banner"> <img width="100px" class="img-responsive" src="{{ URL::asset('public/admin/images/screenshot/') }}/{{ $dir }}/{{ $row->image }}" style="max-width:100px;height: auto;"></a>

                @endif



            </div>



        </td>



        <td>



            <div class="d-flex align-items-center">



                {{ $row->check_in }}



            </div>



        </td>



        <td>



            <div class="d-flex align-items-center">



                {!! $row->check_out !!}



            </div>



        </td>



        <td>



            <div class="d-flex align-items-center">



                {!! nl2br($row->message) !!}



            </div>



        </td> 



        <td>



            <div class="d-flex align-items-center">



                @if($admin_type != 'Admin')





                    @if($row->in_status == 'Absent' || $row->in_status == 'Half Day')



                        <span style="color:red">{{$row->in_status}}</span>



                    @elseif($row->in_status == 'Present')



                        <span style="color:green">{{$row->in_status}}</span>



                    @else



                        <span style="">{{$row->in_status}}</span>



                    @endif



                    

                @else





                    <select name="in_status" id="in_status" class="form-select" onchange="updateInStatus('{{$row->id}}',this.value)">



                        <option {{( $row->in_status == 'Present'?'selected':'' )}} value="Present">Present</option>



                        <option {{( $row->in_status == 'Absent'?'selected':'' )}} value="Absent">Absent</option>



                        <option {{( $row->in_status == 'Half Day'?'selected':'' )}} value="Half Day">Half Day</option>



                    </select>





                @endif                



            </div>



        </td>



        <td>



            <a href="javascript:void(0);" onClick="loadMap('{{$row->latitude}}','{{$row->longitude}}')" class="btn btn-sm btn-primary" title="View Map">



                <i class="bi bi-eye"></i>



            </a>



        </td>



    </tr>



    @endforeach



    @else



    <tr>



        <td align="center" colspan="10">Record not found</td>



    </tr>



    @endif



    <tr>



        <td align="center" colspan="10">



            <div id="pagination">{{ $records->appends(request()->except('page'))->links('vendor.pagination.custom') }}</div>



        </td>



    </tr>