@extends('layout.admin.dashboard')


@section('content')


<div class="page-heading">


   <div class="page-title">


      <div class="row">


         <div class="col-12 col-md-6 order-md-1 order-last">


            <h3>Attendance Form</h3>


            <p class="text-subtitle text-muted">Update your attendance.</p>


         </div>


         <div class="col-12 col-md-6 order-md-2 order-first">


            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">


               <ol class="breadcrumb">


                  <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>


                  <li class="breadcrumb-item active" aria-current="page">Manage Attendance</li>


               </ol>


            </nav>


         </div>


      </div>


   </div>


   <section class="section">


      <div class="row">


         <div class="col-12 col-md-6 order-md-1 order-last">


            <div class="card">


               <div class="card-header">


                  <h4 class="card-title">Recent Information</h4>


               </div>


               <div class="card-body">


                  <form class="form w-100" id="pageForm" action="#">


                     <div class="row">


                        @php


                           $emp_login = Helper::checkTodayAttendence($user_id);


                           $date = date('d-m-Y');


                        @endphp


                        @if($emp_login == '')


                        <div class="col-md-6">


                           <div class="form-group">


                              <label for="basicInput"><b>Current Time:</b> {{date('d-m-Y h:i a')}}</label>


                           </div>


                        </div>


                        <div class="col-md-10">


                           <div class="form-group">


                              <label for="basicInput">Note</label>


                              <textarea class="form-control" rows="5" placeholder="Enter Note" value="" name="message" id="message"></textarea>


                           </div>


                        </div>


                        <div class="col-md-6">


                           <div class="form-group">


                              <label for="basicInput">Current Screen-Shot</label>


                              <input type="file" name="image" id="image" onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])" capture="camera" accept="image/*" class="form-control"/>


                           </div>


                        </div>


                        <div class="col-md-4">


                           <div class="form-group">


                              <img width="100px" src="" id="preview">


                           </div>


                        </div>


                        @else


                        @if(isset($emp_login->id))


                        @if($emp_login->check_out == '')


                        <div class="col-md-6">


                           <div class="form-group">


                              <label for="basicInput"><b>Thank You for Checkin Today</label>


                           </div>


                        </div>


                        @else


                        <div class="col-md-6">


                           <div class="form-group">


                              <label for="basicInput"><b>Thank You for Checkin Today</label>


                              @php


                              $hours = $minutes = 0;


                              if(isset($emp_login->id)){


                                $from_date = strtotime($emp_login->check_in);


                                $to_date = strtotime($emp_login->check_out);


                                $dateDiff = intval((strtotime($emp_login->check_out)-strtotime($emp_login->check_in))/60);


                                $hours = intval($dateDiff/60);


                                $minutes = $dateDiff%60;


                              }


                              @endphp


                              <br>


                              <span>Working Hour: {{ $hours }} Hour - {{$minutes}} Minute</span>


                           </div>


                        </div>


                        @endif


                        @endif


                        @endif


                        <div class="text-left">


                           <!--begin::Submit button-->


                           @if($emp_login == '')


                            <button type="button" id="form_submit" class="btn btn-md btn-primary fw-bolder me-3 my-2">


                            <span class="indicator-label" id="formSubmit">Check In</span>


                           @else


                           @if($emp_login->check_out == '')


                            <button type="button" id="form_submit" class="btn btn-md btn-primary fw-bolder me-3 my-2">


                            <span class="indicator-label" id="formSubmit">Check Out</span>


                           @else


                           @endif                                


                           @endif


                            <span class="indicator-progress d-none">Please wait...


                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>


                            </span>


                           </button>


                           <!--end::Submit button-->


                        </div>


                     </div>


                  </form>


               </div>


            </div>


         </div>


      </div>


   </section>


</div>


<script>


   let returnURL = "{{url('/admin/employee-attendence')}}";   


   let saveDataURL = "{{url('/admin/save-attendence')}}";   


</script>


<script src="{{ asset('public/admin/js/pages/attendence/add-page.js') }}"></script>


@endsection