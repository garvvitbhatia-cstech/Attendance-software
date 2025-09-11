@extends('layout.admin.dashboard')



@section('content')



<link rel="stylesheet" href="{{ asset('public/admin/css/select2.min.css') }}">

<script src="{{ asset('public/admin/js/select2.min.js') }}"></script>



<div class="page-heading">

        <div class="page-title">

            <div class="row">

                <div class="col-12 col-md-6 order-md-1 order-last">

                    <h3>Add New Incentive</h3>

                </div>

                <div class="col-12 col-md-6 order-md-2 order-first">

                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>

                            <li class="breadcrumb-item"><a href="{{url('/admin/incentives')}}">Incentives</a></li>

                            <li class="breadcrumb-item active" aria-current="page">Add Incentive</li>

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

                                        <label for="basicInput">Name</label>

                                        <select name="emp_id" id="emp_id" class="form-select select2">

                                            <option value="">Select Employee</option>

                                        </select>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group">

                                        <label for="basicInput">Amount</label>

                                        <input type="text" name="amount" id="amount" class="form-control numberonly" maxlength="6" placeholder="Total Incentive"/>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group">

                                    <label for="basicInput">Day</label>

                                    <select name="day" id="day" confirmation="false" class="form-select">



                                        <option value="">Day</option>



                                        @for($i=1;$i<=31;$i++)



                                            <option value="{{$i}}">{{$i}}</option>



                                        @endfor



                                    </select>                            



                                </div>



                                </div>



                                <div class="col-md-4">

                                    <div class="form-group">

                                    <label for="basicInput">Month</label>

                                    <select name="month" id="month" confirmation="false" class="form-select">



                                        <option value="">Month</option>



                                        @php



                                            $year = date('Y');



                                            $month_array = array(1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December');



                                        @endphp



                                        @foreach($month_array as $key => $month)

                                            @if($key < 10)
                                                @php $key = '0'.$key; @endphp
                                            @endif

                                            <option value="{{$key}}">{{$month}}</option>



                                        @endforeach



                                    </select>                            



                                </div>



                                </div>



                                <div class="col-md-4">

                                    <div class="form-group">

                                    <label for="basicInput">Year</label>

                                    <select name="year" id="year" confirmation="false" class="form-select">



                                        <option value="">Year</option>



                                        @for($i=2024;$i<=2030;$i++)



                                            <option value="{{$i}}">{{$i}}</option>



                                        @endfor



                                    </select>



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

    $('.select2').select2({

        ajax: {

            url:"{{ url('/admin/get-employee-list') }}",

            dataType: 'JSON',

            delay: 250,

            processResults: function (data) {

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

	$(document).ready(function(){

		$('.numberonly').keypress(function(e){

			var charCode = (e.which) ? e.which : event.keyCode

			if(String.fromCharCode(charCode).match(/[^0-9+]/g))

			return false;

		});

    });

    let saveDataURL = "{{url('/admin/add-incentive')}}";

    let returnURL = "{{url('/admin/incentives')}}";

</script>

<script src="{{ asset('public/admin/js/pages/incentives/add-page.js') }}"></script>



@endsection