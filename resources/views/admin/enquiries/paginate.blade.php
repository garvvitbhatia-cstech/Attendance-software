@if($records->count()>0)
   @foreach($records as $key => $row)
   @php
   	$class = 'd-flex';
   	if($row->read_status == 2){ $class = 'fw-bold'; }
    $count = $records->count();
    $last = 	$records->lastItem();
    $page = $records->currentPage();
    $sr = $key+1;
    if($page > 1){
        $sr = ($last-$count)+$key+1;
    }
   @endphp
   <tr>
       <td>
           <div class="{{$class}} align-items-center">
               {!! $sr !!}
           </div>
       </td>
       <td>
           <div class="{{$class}} align-items-center">
               {!! $row->name !!}
           </div>
       </td>
       <td>
           <div class="{{$class}} align-items-center">
               {!! $row->email !!}
           </div>
       </td>
       <td>
           <div class="{{$class}} align-items-center">
               {!! $row->contact !!}
           </div>
       </td>
       <td>
           <span class="{{$class}} align-items-center">{!! date('d M, Y h:i A',strtotime($row->created_at)) !!}</span>
       </td>
       <td>
           <a href="{{ url('/admin/view-enquiry',base64_encode($row->id)) }}" class="btn btn-sm btn-primary" title="View">
               <i class="bi bi-eye"></i>
           </a>
           <a href="javascript:void(0);" onclick="deleteData('contacts','{{ $row->id }}');" class="btn btn-sm btn-danger" title="Delete">
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