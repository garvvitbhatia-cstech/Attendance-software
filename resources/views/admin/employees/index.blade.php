@extends('layout.admin.dashboard')
@section('content')
<div class="page-heading">
   <div class="page-title">
      <div class="row">
         <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Employee Management</h3>
            <p class="text-subtitle text-muted"><b>Total Employee: <span id="replaceCountUser">0</span></b></p>
         </div>
         <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Employee</li>
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
                  <div class="row">
                  <!--begin::Input group-->
                  <div class="position-relative col-12 col-md-3">
                     <input id="name" name="name" confirmation="false" class="form-control" placeholder="Search By Name">
                  </div>
                  <div class="position-relative col-12 col-md-3">
                     <input id="email" name="email" confirmation="false" class="form-control" placeholder="Search By Email">
                  </div>
                  <div class="position-relative col-12 col-md-2">
                     <input id="mobile" name="mobile" confirmation="false" class="form-control" placeholder="Search By Phone">
                  </div>
                  <div class="position-relative col-12 col-md-2">
                     <select name="status" id="status" class="form-select">
                     	<option value="">Select Status</option>
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
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
            <a target="_blank" href="{{url('/')}}" class="btn icon btn-sm btn-outline-success float-end">Add New Employee</a>
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
                              <th>PROFILE</th>
                              <th>SALARY</th>
                              <th>STATUS</th>
                              <th>CREATED</th>
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
<script>
   function exportData(){   
       $('#exportCsvBtn').html('......');
       $.ajax({
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           type: "POST",
           url: "{{route('exports.employee')}}",
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

   $(document).ready(function(){      
       filterData('simple');        
   });      

    function filterData(type = null){      
    if(type =='search'){$('#searchbuttons').html('Searching..');}      
   	    $.ajax({      
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},      
            type: 'POST',      
            data: $('#searchForm').serialize(),   
      		url: "{{ url('/admin/employee_paginate') }}",        
            success: function(response){        
                $('#replaceHtml').html(response);   
                $('#replaceCountUser').html($('#count_employee').val());
                $('#searchbuttons').html('Search');        
            }  
      	});   
    }   
	function printOfferLetter(rowID){
		var pdf = "{{url('/storage/pdf/offer_letter.pdf')}}";
		$.ajax({
			type: 'POST',
			url: "{{ url('admin/print-offer-letter') }}",
			data:{rowID:rowID},
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(msg){
				// Create an IFrame.
				var iframe = document.createElement('iframe');
				// Hide the IFrame.
				iframe.style.visibility = "hidden";
				// Define the source.
				iframe.src = pdf;
				// Add the IFrame to the web page.
				document.body.appendChild(iframe);
				iframe.contentWindow.focus();
				iframe.contentWindow.print(); // Print.			
			},error: function(ts){
				alert("Something went wrong");
			}
		});	
	}
</script>
@endsection