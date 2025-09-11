@if($records->count()>0)
    @foreach($records as $key => $row)
    <tr>
        <td>
            <div class="d-flex align-items-center">
                @php
                    $user_details = Helper::getUserInfo($row->emp_id);
                @endphp
                {!! $user_details->name .' ('.$user_details->emp_id.')' !!}
            </div>
        </td>
        <td>
            <div class="d-flex align-items-center">
                {!! date('d-F-Y',strtotime($row->incentive_date)) !!}
            </div>
        </td>
        <td>
            <div class="d-flex align-items-center">
                ₹ {!! $row->amount !!}
            </div>
        </td>
        <td>
            <span class="text-muted fw-bold text-muted d-block fs-7">{!! date('d M, Y h:i A',strtotime($row->created_at)) !!}</span>
        </td>
        <td>
            <a href="{{ url('/admin/edit-incentive',base64_encode($row->id)) }}" class="btn btn-sm btn-primary" title="Edit">
                <i class="bi bi-pencil"></i>
            </a>
            <a href="javascript:void(0);" onclick="deleteData('incentives','{{ $row->id }}');" class="btn btn-sm btn-danger" title="Delete">
                <i class="bi bi-trash"></i>
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