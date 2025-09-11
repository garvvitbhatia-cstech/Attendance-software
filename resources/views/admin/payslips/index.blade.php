@extends('layout.admin.dashboard')
@section('content')

<div class="page-heading">
   <div class="page-title">
      <div class="row">
         <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Payslip Management</h3>
            <p class="text-subtitle text-muted">Payslip list.</p>
         </div>
         <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Payslip</li>
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
               <div class="d-flex align-items-center  w-md-800px">
                  <!--begin::Input group-->
                  @php
                  $current_date = date('Y');
                  @endphp
                  <div class="position-relative w-md-200px me-md-2">
                     <select name="year" id="year" class="form-select">
                        <option value="">Select Year</option>
                        @for($x=2024; $x<="$current_date";$x++)
                        <option value="{{$x}}">{{$x}}</option>
                        @endfor
                     </select>
                  </div>
                  <div class="position-relative w-md-200px me-md-2">
                     <select name="month" id="month" class="form-select">
                        <option value="">Select Month</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">Octomber</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                     </select>
                  </div>
                  <!--end::Input group-->
                  <!--begin:Action-->
                  <div class="d-flex align-items-center">
                     <button type="button" id="searchbuttons" onclick="filterData('search');" style="margin-right:10px;" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Search</button>
                     <button type="reset" class="btn btn-sm btn-dark btn-active-light-primary me-5" data-kt-menu-dismiss="true"  onclick="resetFilterForm();">Reset</button>
                  </div>
                  <!--end:Action-->
               </div>
            </form>
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
                              <th>YEAR</th>
                              <th>MONTH</th>
                              <th>DAYS</th>
                              <th>TOTAL LEAVE</th>
                              <th>WORKING DAYS</th>
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
<div class="modal fade" id="payslip_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="current_month_salary"></h5>
            <button type="button" class="close" data-dismiss="modal" onclick="closeModal()" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="table-outer">
               <table class="table table-bordered table-hover">
                  <thead>
                     <tr>
                        <th scope="col">#</th>
                        <th scope="col">Employee</th>
                        <th scope="col">Present</th>
                        <th scope="col">Leave</th>
                        <th scope="col">Salary</th>
                        <th scope="col">Action</th>
                     </tr>
                  </thead>
                  <tbody id="replaceReport"></tbody>
               </table>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" onclick="closeModal()" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" onclick="" id="exportCsvBtn" class="btn btn-primary">Export CSV</button>
         </div>
      </div>
   </div>
</div>
<style>
   .table-outer { overflow-x: auto; max-height:500px; }
</style>
<script>
   function updateTotalLeave(rowID,days,value){
      if(rowID != '' && days != '' && value != ''){
         if(value >= 0){
            $.ajax({
               type: 'POST',
               url: "{{ url('admin/update-total-leave') }}",
               data:{rowID:rowID,days:days,value:value},
               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
               success: function(msg){
                  filterData('simple');
               },error: function(ts){
                  alert("Something went wrong");
               }
            });	
         }else{
            filterData('simple');   
         }
      }else{
         filterData('simple');   
      }
   }
   function printPayslip(rowID,year,month){
        var pdf = "{{url('/storage/pdf/payslip.pdf')}}";
        $.ajax({
            type: 'POST',
            url: "{{ url('admin/generate-employee-payslip') }}",
            data:{rowID:rowID,year:year,month:month},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(msg){
                // Create an IFrame.
                var iframe = document.createElement('iframe');
                // Hide the IFrame.
                iframe.style.visibility = "hidden";
                // Defin the source.
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
   function viewDetails(row_id){   
   	$('#details_'+row_id).toggle();   
   }   
   
   function closeModal(){   
       $('#payslip_modal').modal('hide');   
   }   
   
    function exportCsv(month,year){   
        if(month != '' && year != ''){   
            $('#exportCsvBtn').html('......');   
            $('#exportCsvBtn').attr('disabled',true);   
            $.ajax({   
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},   
                type: "POST",   
                url: "{{route('exports.payslip')}}",   
                data: {month:month,year:year},   
                success: function(msg){
                    $('#exportCsvBtn').html('Export CSV');   
                    $('#exportCsvBtn').attr('disabled',false);   
                    window.location.href = msg;   
                    $('#payslip_modal').modal('hide');   
                },error: function(ts){   
                    $('#error500').modal('show');   
                }   
            });   
            return false;   
        }   
    }      
   
    function getPayaslip(month,year){   
        if(month != '' && year != ''){   
           $('#exportCsvBtn').attr('onclick','exportCsv("'+month+'","'+year+'")');   
           $('#current_month_salary').html(month+'-'+year+' Report');   
           $('#replaceReport').html('<tr><td colspan="6" class="text-center">Processing...</td></tr>');   
           $('#payslip_modal').modal('show');    
   
           $.ajax({   
               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},   
               type: 'POST',   
               data: {month:month, year:year},   
               url: "{{ url('/admin/get-current-payslip') }}",   
               success: function(response){   
                   $('#replaceReport').html(response);   
               }   
           });   
           return false;
        }
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
            url: "{{ url('/admin/payslips_paginate') }}",    
            success: function(response){    
                $('#replaceHtml').html(response);    
                $('#searchbuttons').html('Search');    
            }    
        });
    }   
</script>
@endsection