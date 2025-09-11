@extends('layout.admin.dashboard')

@section('content')

<link rel="stylesheet" href="{{ asset('public/admin/css/select2.min.css') }}">
<script src="{{ asset('public/admin/js/select2.min.js') }}"></script>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Add New Employee Advance</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/admin/advance')}}">Advance</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Advance</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
    <form class="form w-100" id="pageForm" action="#">
        <div class="row">
            <div class="col-9 col-md-9">
            <div class="card">
                    <div class="card-body"> 
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="basicInput">Employee</label>
                                    <select name="user_id" id="user_id" class="form-select select2">
                                        <option value="">Select Employee</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="basicInput">Amount</label>
                                    <input type="text" class="form-control" placeholder="Enter Amount" value="" name="amount" id="amount">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="basicInput">Mode</label>
                                    <select name="mode" id="mode" class="form-select" onchange="checkMode(this.value)">
                                        <option value="Full Amount">Full Amount</option>
                                        <option value="Installment">Installment</option>                                            
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 installment_amt_div" style="display:none;">
                                <div class="form-group">
                                    <label for="basicInput">Installment Amount</label>
                                    <input type="text" class="form-control" placeholder="Enter Installment Amount" value="0" name="installment" id="installment">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="basicInput">Date</label>
                                    <input type="date" class="form-control" placeholder="Enter date" value="" name="date" id="date">
                                </div>
                            </div>
                            <div class="text-left  p-3 p-l-20">
                                <!--begin::Submit button-->
                                <button type="button" id="form_submit" class="btn btn-sm btn-primary fw-bolder me-3 my-2">
                                    <span class="indicator-label" id="formSubmit">Submit</span>
                                    <span class="indicator-progress d-none">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                                <!--end::Submit button-->
                            </div>
                        </div>                            
                    </div>                        
                </div>
            </div>
        </div>        
    </div>
     </form>
    </section>
</div>
<!-- end plugin js -->
<style>
.select2-container--default .select2-selection--single {
  background-color: #fff;
  border: 0;
  border-radius: 0px;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #607080;
    line-height: 35px;
    border-radius: .25rem;
    border: 1px solid #dce7f1;
    vertical-align: middle;
}

.select2-container .select2-selection--single {
  box-sizing: border-box;
  cursor: pointer;
  display: block;
  height: 36px;
  user-select: none;
  -webkit-user-select: none;
}
</style>
<script>  
	function checkMode(mode){
		$('.installment_amt_div').hide();
		if(mode == 'Installment'){
			$('.installment_amt_div').show();
		}
	}
	$('.select2').select2({
      ajax: {
        url:"{{ url('/admin/get-employee-list') }}",
        dataType: 'JSON',
        delay: 250,
        processResults: function(data){
          return {
            results: $.map(data, function (item){
                return {						
                    text: item.title,
                    id: item.id
                }
            })
          };
        },
        cache: true
      }
    });  
	$(document).ready(function () {
		$('.numberonly').keypress(function(e){
			var charCode = (e.which) ? e.which : event.keyCode
			if(String.fromCharCode(charCode).match(/[^0-9+]/g))
			return false;
		});
    }); 
    let saveDataURL = "{{url('/admin/add-advance')}}";
    let returnURL = "{{url('/admin/advance')}}";
</script>
<script src="{{ asset('public/admin/js/pages/advance/add-page.js') }}"></script>

@endsection