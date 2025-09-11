@extends('layout.admin.dashboard')

@section('content')


<div class="page-heading">


    <div class="page-title">


        <div class="row">


            <div class="col-12 col-md-6 order-md-1 order-last">


                <h3>Attendance Management</h3>


                <p class="text-subtitle text-muted">Attendance list.</p>


            </div>


            <div class="col-12 col-md-6 order-md-2 order-first">


                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">


                    <ol class="breadcrumb">


                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>


                        <li class="breadcrumb-item active" aria-current="page">attendance</li>


                    </ol>


                </nav>


            </div>


        </div>


    </div>


    <section class="section">


        <div class="card">


           <!--begin::Card body-->


            <div class="card-body">


                <!--begin::Compact form-->


                <form id="searchForm" name="searchForm" class="float-start">


                    <div class="d-flex align-items-center">


                        <!--begin::Input group-->


                        <div class="row">


                        <div class="position-relative col-12 col-md-2">


                            <input type="date" name="from_date" id="from_date" class="form-control"/>


                        </div>


                        <div class="position-relative col-12 col-md-2">


                            <input type="date" name="to_date" id="to_date" class="form-control"/>


                        </div>


                        <div class="position-relative col-12 col-md-2">


                            <input type="text" name="employee_id" id="employee_id" placeholder="Employee ID" class="form-control"/>


                        </div>


                        <div class="position-relative col-12 col-md-2">


                            <input type="text" name="name" id="name" class="form-control" placeholder="Employee Name"/>


                        </div>



                        <!--<div class="position-relative col-12 col-md-2">


                            <select name="day" id="day" confirmation="false" class="form-select">


                                <option value="">Day</option>


                                @for($i=1;$i<=31;$i++)


                                    <option value="{{$i}}">{{$i}}</option>


                                @endfor


                            </select>                            


                        </div>


                        <div class="position-relative col-12 col-md-2">


                            <select name="month" id="month" confirmation="false" class="form-select">


                                <option value="">Month</option>


                                @php


                                    $year = date('Y');


                                    $month_array = array(1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December');


                                @endphp


                                @foreach($month_array as $key => $month)


                                    <option value="{{$key}}">{{$month}}</option>


                                @endforeach


                            </select>                            


                        </div>

                        <div class="position-relative col-12 col-md-2">


                            <select name="year" id="year" confirmation="false" class="form-select">


                                <option value="">Year</option>


                                @for($i=2024;$i<=2030;$i++)


                                    <option value="{{$i}}">{{$i}}</option>


                                @endfor


                            </select>


                        </div>--->


                        <div class="position-relative col-12 col-md-2">


                            <select name="in_status" id="in_status" confirmation="false" class="form-select">


                                <option value="">Status</option>


                                <option value="Present">Present</option>


                                <option value="Absent">Absent</option>


                                <option value="Half Day">Half Day</option>


                            </select>


                        </div>


                        <!--end::Input group-->


                        <!--begin:Action-->


                        <div class="d-flex align-items-center col-12 col-md-2">


                            <button type="button" id="searchbuttons" onclick="filterData('search');" style="margin-right:10px;" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Search</button>


                            <button type="reset" class="btn btn-sm btn-dark btn-active-light-primary me-5" data-kt-menu-dismiss="true"  onclick="resetFilterForm();">Reset</button>


                        </div>


                        <!--end:Action-->


                        </div>


                    </div>


                </form>


                <a onclick="exportData();" id="exportCsvBtn" class="btn icon btn-sm btn-outline-primary float-end" style="margin-left:10px">Export CSV</a>

                <a data-bs-toggle="modal" data-bs-target="#uploadCsvModal" class="btn icon btn-sm btn-outline-warning float-end" style="margin-left:10px">Import CSV</a>

            </div>


            <!--end::Card body-->


        </div>


    </section>

    <!-- Table head options start -->

    <section class="section">

        <div class="row" id="table-head">

            <div class="col-12">

                <div class="card">

                    <div class="card-content">

                        <!-- table head dark -->

                        <div class="table-responsive">

                            <table class="table mb-0">

                                <thead class="thead-dark">

                                    <tr>

                                        <th>#</th>

                                        <th>EMPLOYEE</th>

                                        <th>DATE</th>

                                        <th>SCREENSHOT</th>

                                        <th>CHECK-IN</th>

                                        <th>CHECK-OUT</th>  

                                        <th width="20%">NOTE</th> 

                                        <th>STATUS</th>                                        

                                        <th>ACTION</th>

                                    </tr>

                                </thead>

                                <tbody id="replaceHtml">
                                    <tr>
                                        <td colspan="10" class="text-center"><img src="{{ asset('public/admin/images/svg/oval.svg') }}" class="me-4" style="width: 3rem" alt="audio"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- Table head options end -->

</div>

<div class="modal fade" id="uploadCsvModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

      <div class="modal-dialog">

        <div class="modal-content">

          <div class="modal-header">

            <h5 class="modal-title" id="exampleModalLabel">Import CSV</h5>

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

          </div>

          <div class="modal-body">

            <div class="form-group">

            <label for="basicInput">Choose File</label>

            <input type="file" class="form-control" name="upload_csv_file" id="upload_csv_file">

            </div>

          </div>

          <div class="modal-footer">

          <a href="{{url('/storage/sample-csv/employee_attendance.csv')}}" target="_blank" class="btn btn-success">Download Sample CSV</a>

            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

            <button type="button" onclick="UploadCSV();" id="uploadCsvBtn" class="btn btn-primary">Upload</button>

          </div>

        </div>

      </div>

</div>

<!-------------------------------->

<div class="modal" id="my_map" tabindex="-1" role="dialog">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title">Login Route</h5>

        <button type="button" onclick="closeMap()" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body" id="replaceMap">Processing...</div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" onclick="closeMap()" data-dismiss="modal">Close</button>

      </div>

    </div>

  </div>

</div>

<style>
    #replaceMap {
      width: 100%;
      height: 400px;
    }
</style>

<script>
function UploadCSV(){
    if($.trim($('#upload_csv_file').val()) != ''){
        var file_data = $('#upload_csv_file').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        $('#uploadCsvBtn').html('......');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "{{route('imports.employee-attendance')}}",
            dataType: 'text',  // <-- what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(msg){
                $('#uploadCsvBtn').html('Upload');
                if(msg == 'Success'){
                    $('#uploadCsvModal').modal('hide');
                    swal("", "CSV Uploaded successfully", "success").then((value) => {});
                    resetFilterForm();
                }else if(msg == 'InvalidFileType'){
                    swal("Error!", 'Please select valid file format', "error");
                }else if(msg == 'ChoseFile'){
                    swal("Error!", 'Please choose file', "error");
                }
            },error: function(ts){
                $('#error500').modal('show');
            }
        });
    }
}
function updateInStatus(row,value){
	if(row != "" && value != ""){
        swal({
			title: "Are you sure?",
			text: "You want to change status.",
			icon: "warning",
			buttons: true,
			dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                url: "{{route('admin.update-attendence')}}",
                data: {row:row,value:value},
                success: function(msg){
                    swal({
                    title: 'Success',
                    text: 'Status Change Successfully.',
                    type: 'success',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: "#009EF7"});
                    filterData('simple');
                },error: function(ts){
                    filterData('simple');
                    $('#error500').modal('show');
                }
            });
            return false;
        }else{
            filterData('simple');
            //swal("Your status is safe!");
        }
        });
	}else{
        filterData('simple');
		return false;
	}
}

function exportData(){
    $('#exportCsvBtn').html('......');
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "POST",
        url: "{{route('exports.employee.attendance')}}",
        data: $('#searchForm').serialize(),
        success: function(msg){
            $('#exportCsvBtn').html('Export CSV');
            window.location.href = msg;
        },error: function(ts){
            $('#error500').modal('show');
        }
    });
    return false;
}

function closeMap(){
    $('#my_map').modal('hide');
}

function loadMap(lat,lng){
    $("#replaceMap").html('Processing...');
    $('#my_map').modal('show');
    // Create the Google Maps URL
    var mapUrl = "https://www.google.com/maps?q=" + lat + "," + lng + "&z=15&zoom=4&maptype=satellite&output=embed";

    // Embed the Google Map in an iframe
    var iframe = $("<iframe>")
        .attr("src", mapUrl)
        .attr("width", "100%")
        .attr("height", "400px")
        .attr("frameborder", "0")
        .css("border", "0")
        .css("allowfullscreen", "")
        .css("loading", "lazy");
    // Append the iframe to the map container    
    $("#replaceMap").html(iframe);
}

$(document).ready(function(){
    filterData('simple');
});

function filterData(type = null){
    if(type =='search'){$('#searchbuttons').html('Searching..');}
	$.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
		data: $('#searchForm').serialize(),
		url: "{{ url('/admin/attendence_paginate') }}",
		success: function(response){
			$('#replaceHtml').html(response);
            $('#searchbuttons').html('Search');
		}
	});
}
</script>
@endsection