<input type="hidden" id="count_employee" value="{{$count}}"/>

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

            <span>

                <b>Name: </b>{!! $row->name !!} ({{$row->emp_id}})<br>

                <b>Email: </b>{!! $row->email !!}<br>

                <b>Mobile: </b>{!! $row->mobile !!}<br>

            </span>

            </div>


        </td>


        <td>

            <div class="d-flex align-items-center">

                @if($row->profile != "")

                    <a target="_blank" href="{{URL::asset('public/admin/images/users/')}}/{!! $row->profile !!}"><img src="{{URL::asset('public/admin/images/users/')}}/{!! $row->profile !!}" style="max-width:90px;height: auto;"></a>

                @endif

            </div>

        </td>


        <td>


            <div class="d-flex align-items-center">

                <span>
                @php
                $basic = ($row->salary * 50)/100;
                @endphp
                <b>Basic: </b>₹ {{ ($row->salary * 50)/100 }}<br>

                <b>HRA: </b>₹ {{ ($basic * 40)/100 }}<br>

                <b>SA: </b>₹ {{ ($basic * 60)/100 }}<br>

                <b>Total: </b>₹ {!! $row->salary !!}

                </span>

            </div>


        </td>


        <td>


            @if($row->status == 1)

                <a href="javascript:void(0);" onclick="changeStatus('users','{!!$row->id!!}','{!!$row->status!!}');" class="badge bg-success">Active</a>

            @else

                <a href="javascript:void(0);" onclick="changeStatus('users','{!!$row->id!!}','{!!$row->status!!}');" class="badge bg-danger">In-Active</a>

            @endif


        </td>


        <td>

            <span class="text-muted fw-bold text-muted d-block fs-7">{!! date('d M, Y h:i A',strtotime($row->created_at)) !!}</span>

        </td>


        <td>


            <a href="javascript:void(0)" onclick="printOfferLetter('{{base64_encode($row->id)}}')" class="btn btn-sm btn-info" title="Offer Letter">

                Offer Letter

            </a>



        	<a href="{{ url('/admin/edit-employee',base64_encode($row->id)) }}" class="btn btn-sm btn-primary" title="Edit">

                <i class="bi bi-pencil"></i>

            </a>


            <a href="javascript:void(0);" onclick="deleteData('users','{{ $row->id }}');" class="btn btn-sm btn-danger"  title="Delete">

                <i class="bi bi-trash"></i>

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