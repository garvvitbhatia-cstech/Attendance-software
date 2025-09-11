@extends('layout.default')


@section('content')





<style>


.required:after {


  content:"*";


  color:red;


}


</style>





<div class="container-fluid">


  <div class="container">     


    <!-- Title -->    


    <div class="d-flex justify-content-between align-items-lg-center py-3 flex-column flex-lg-row">


      <h2 class="h5 mb-3 mb-lg-0">Employee Joining Form</h2>


    </div>    


    <!-- Main content -->    


    <div class="row">


      <form class="pageForm" id="pageForm" action="#">


        <div class="col-lg-12">           


          <!-- Basic information -->          


          <div class="card mb-4">


            <div class="card-body">


              <h3 class="h6 mb-4">Personal Details</h3>


              <div class="row">


                <div class="col-lg-4">


                  <div class="mb-3">


                    <label class="form-label required">First Name</label>


                    <input type="text" class="form-control first_name textonly" onkeyup="$('#first_nameError').remove()" name="first_name" id="first_name" placeholder="First name">


                  </div>


                </div>


                <div class="col-lg-4">


                  <div class="mb-3">


                    <label class="form-label">Middle Name</label>


                    <input type="text" class="form-control middle_name textonly" onkeyup="$('#middle_nameError').remove()" name="middle_name" id="middle_name" placeholder="Middle name"/>


                  </div>


                </div>


                <div class="col-lg-4">


                  <div class="mb-3">


                    <label class="form-label required">Last Name</label>


                    <input type="text" class="form-control last_name textonly" onkeyup="$('#last_nameError').remove()" name="last_name" id="last_name" placeholder="Last Name"/>


                  </div>


                </div>


                <div class="col-lg-6">


                  <div class="mb-3">


                    <label class="form-label required">Father Name</label>


                    <input type="text" class="form-control father_name textonly" onkeyup="$('#father_nameError').remove()" name="father_name" id="father_name" placeholder="Father Name"/>


                  </div>


                </div>


                <div class="col-lg-3">


                  <div class="mb-3">


                    <label for="formFile" class="form-label required">Profile Photo</label>


                    <input class="form-control profile" onclick="$('#profileError').remove()" type="file" name="profile" id="profile">


                  </div>


                </div>


                <div class="col-lg-3">


                  <div class="mb-3">


                    <label for="formFile" class="form-label required">Aadhaar Card</label>


                    <input class="form-control aadhaar" onclick="$('#aadhaarError').remove()" type="file" name="aadhaar" id="aadhaar">


                  </div>


                </div>


                <div class="col-lg-12">


                  <div class="mb-3">


                    <label class="form-label required">Correspondence Address</label>


                    <input type="text" class="form-control correspondence_address" onkeyup="$('#correspondence_addressError').remove()" name="correspondence_address" id="correspondence_address" placeholder="Correspondence Address"/>


                  </div>


                </div>


                <div class="col-lg-12">


                  <div class="mb-3">


                    <label class="form-label required">Permanent Address</label>


                    <input type="text" class="form-control permanent_address" onkeyup="$('#permanent_addressError').remove()" name="permanent_address" id="permanent_address" placeholder="Permanent Address"/>


                  </div>


                </div>


                <div class="col-lg-4">


                  <div class="mb-3">


                    <label class="form-label required">Telephone</label>


                    <input type="tel" class="form-control numberonly telephone" onkeyup="$('#telephoneError').remove()" name="telephone" maxlength="10" id="telephone" placeholder="Telephone"/>


                  </div>


                </div>


                <div class="col-lg-4">


                  <div class="mb-3">


                    <label class="form-label required">Mobile</label>


                    <input type="tel" class="form-control numberonly mobile" onkeyup="$('#mobileError').remove()" name="mobile" maxlength="10" id="mobile" placeholder="Mobile"/>


                  </div>


                </div>


                <div class="col-lg-4">


                  <div class="mb-3">


                    <label class="form-label required">Email</label>


                    <input type="text" class="form-control email" name="email" onkeyup="$('#emailError').remove()" id="email" placeholder="Email"/>


                  </div>


                </div>


                <div class="col-lg-6">


                  <div class="mb-3">


                    <label class="form-label required">Date of Birth</label>


                    @php                    


                      $afterdate = date('Y-m-d', strtotime('-18 year'));                    


                    @endphp


                    <input type="date" class="form-control dob" max="{{$afterdate}}" onclick="$('#dobError').remove()" name="dob" id="dob" placeholder="Date of Birth"/>


                  </div>


                </div>


                <div class="col-lg-6">


                  <div class="mb-3">


                    <label class="form-label required">Marital Status</label>


                    <select class="form-control" name="marital_status" id="marital_status"/>


                    


                    <option value="Single">Single</option>


                    <option value="Married">Married</option>


                    </select>


                  </div>


                </div>


                <div class="col-lg-6">


                  <div class="mb-3">


                    <label class="form-label required">PAN Card</label>


                    <input type="text" class="form-control pan_card" name="pan_card" onkeyup="$('#pan_cardError').remove()" id="pan_card" placeholder="PAN Card"/>


                  </div>


                </div>


                <div class="col-lg-6">


                  <div class="mb-3">


                    <label class="form-label">Blood Group</label>


                    <input type="text" class="form-control" name="blood_group" onkeyup="$('#blood_groupError').remove()" id="blood_group" placeholder="Blood Group"/>


                  </div>


                </div>


                <div class="col-lg-12">


                  <h6 class="mb-2">Emergency Contact Details</h6>


                </div>


                <div class="col-lg-4">


                  <div class="mb-3">


                    <label class="form-label required">Name</label>


                    <input type="text" class="form-control emergency_name textonly" onkeyup="$('#emergency_nameError').remove()" name="emergency_name" id="emergency_name" placeholder="Name"/>


                  </div>


                </div>


                <div class="col-lg-4">


                  <div class="mb-3">


                    <label class="form-label required">Relation</label>


                    <input type="text" class="form-control emergency_relation" onkeyup="$('#emergency_relationError').remove()" name="emergency_relation" id="emergency_relation" placeholder="Relation"/>


                  </div>


                </div>


                <div class="col-lg-4">


                  <div class="mb-3">


                    <label class="form-label required">Contact No</label>


                    <input type="tel" class="form-control numberonly emergency_contact" onkeyup="$('#emergency_contactError').remove()" name="emergency_contact" maxlength="10" id="emergency_contact" placeholder="Contact No"/>


                  </div>


                </div>


              </div>


            </div>


          </div>


          


          <!---- account detqils--------->


          


          


          <div class="card mb-4">


            <div class="card-body">


              <h3 class="h6 mb-4">Account Details</h3>


              <div class="row">


                <div class="col-lg-4">


                  <div class="mb-3">


                    <label class="form-label required">Account Number</label>


                    <input type="text" class="form-control account_no numberonly" maxlength="20" onkeyup="$('#account_noError').remove()" name="account_no" id="account_no" placeholder="Account Number">


                  </div>


                </div>


                <div class="col-lg-4">


                  <div class="mb-3">


                    <label class="form-label required">IFSC</label>


                    <input type="text" class="form-control ifsc" onkeyup="$('#ifscError').remove()" name="ifsc" id="ifsc" placeholder="IFSC"/>


                  </div>


                </div>


                <div class="col-lg-4">


                  <div class="mb-3">


                    <label class="form-label required">Bank Name</label>


                    <input type="text" class="form-control bank_name" onkeyup="$('#bank_nameError').remove()" name="bank_name" id="bank_name" placeholder="Bank Name"/>


                  </div>


                </div>


                <div class="col-lg-4">


                  <div class="mb-3">


                    <label class="form-label required">Acount Holder Name</label>


                    <input type="text" class="form-control account_holder_name textonly" name="account_holder_name" onkeyup="$('#account_holder_nameError').remove()"  id="account_holder_name" placeholder="Acount Holder Name"/>


                  </div>


                </div>


                <div class="col-lg-3">


                  <div class="mb-3">


                    <label for="formFile" class="form-label required">Account Image</label>


                    <input class="form-control account_image" onclick="$('#account_imageError').remove()" type="file" name="account_image" id="account_image">


                  </div>


                </div>


              </div>


            </div>


          </div>


          


          


          <!-- Educational -->


          


          <div class="card mb-4">


            <div class="card-body">


              <h3 class="h6 mb-4">Educational Details</h3>


              <div class="row">


                <div class="col-lg-2">


                  <label class="form-label">Degree</label>


                  <input type="text" class="form-control" name="education_degree[]" id="education_degree" placeholder="Degree 1"/>


                </div>


                <div class="col-lg-2">


                  <label class="form-label">University/Institute</label>


                  <input type="text" class="form-control" name="education_univesity[]" id="education_univesity" placeholder="University/Institute 1"/>


                </div>


                <div class="col-lg-2">


                  <label class="form-label">From</label>


                  <input type="date" class="form-control" name="education_from[]" id="education_from" placeholder="From 1"/>


                </div>


                <div class="col-lg-2">


                  <label class="form-label">To</label>


                  <input type="date" class="form-control" name="education_to[]" id="education_to" placeholder="To 1"/>


                </div>


                <div class="col-lg-2">


                  <label class="form-label">Percentage/Grade</label>


                  <input type="text" class="form-control" name="education_percentage[]" id="education_percentage" placeholder="Percentage/Grade 1"/>


                </div>


                <div class="col-lg-2">


                  <label class="form-label">Specialization</label>


                  <input type="text" class="form-control" name="education_specialization[]" id="education_specialization" placeholder="Specialization 1"/>


                </div>


              </div>


              @for($i=1;$i<=4;$i++)


              <div class="row">


                <div class="col-lg-2">


                  <label class="form-label">&nbsp;</label>


                  <input type="text" class="form-control" name="education_degree[]" id="education_degree" placeholder="Degree {{$i+1}}"/>


                </div>


                <div class="col-lg-2">


                  <label class="form-label">&nbsp;</label>


                  <input type="text" class="form-control" name="education_univesity[]" id="education_univesity" placeholder="University/Institute {{$i+1}}"/>


                </div>


                <div class="col-lg-2">


                  <label class="form-label">&nbsp;</label>


                  <input type="date" class="form-control" name="education_from[]" id="education_from" placeholder="From {{$i+1}}"/>


                </div>


                <div class="col-lg-2">


                  <label class="form-label">&nbsp;</label>


                  <input type="date" class="form-control" name="education_to[]" id="education_to" placeholder="To {{$i+1}}"/>


                </div>


                <div class="col-lg-2">


                  <label class="form-label">&nbsp;</label>


                  <input type="text" class="form-control" name="education_percentage[]" id="education_percentage" placeholder="Percentage/Grade {{$i+1}}"/>


                </div>


                <div class="col-lg-2">


                  <label class="form-label">&nbsp;</label>


                  <input type="text" class="form-control" name="education_specialization[]" id="education_specialization" placeholder="Specialization {{$i+1}}"/>


                </div>


              </div>


              @endfor 


            </div>


          </div>


          


          <div class="card mb-4">


            <div class="card-body">


              <h3 class="h6 mb-4">Employee Details (Last Two Organisations)</h3>


              <div class="row">


                <div class="col-lg-4">


                  <label class="form-label">Organisation</label>


                  <input type="text" class="form-control" name="employee_organisation[]" id="employee_organisation" placeholder="Organisation 1"/>


                </div>


                <div class="col-lg-2">


                  <label class="form-label">Designation</label>


                  <input type="text" class="form-control" name="employee_designation[]" id="employee_designation" placeholder="Designation 1"/>


                </div>


                <div class="col-lg-2">


                  <label class="form-label">Service Period (From)</label>


                  <input type="date" class="form-control" name="employee_from_service_period[]" id="employee_from_service_period" placeholder="Service Period (From) 1"/>


                </div>


                <div class="col-lg-2">


                  <label class="form-label">Service Period (To)</label>


                  <input type="date" class="form-control" name="employee_to_service_period[]" id="employee_to_service_period" placeholder="Service Period (To) 1"/>


                </div>


                <div class="col-lg-2">


                  <label class="form-label">Annual CTC</label>


                  <input type="text" class="form-control" name="employee_ctc[]" id="employee_ctc" placeholder="Annual CTC 1"/>


                </div>


              </div>


              <div class="row">


                <div class="col-lg-4">


                  <label class="form-label">&nbsp;</label>


                  <input type="text" class="form-control" name="employee_organisation[]" id="employee_organisation" placeholder="Organisation 2"/>


                </div>


                <div class="col-lg-2">


                  <label class="form-label">&nbsp;</label>


                  <input type="text" class="form-control" name="employee_designation[]" id="employee_designation" placeholder="Designation 2"/>


                </div>


                <div class="col-lg-2">


                  <label class="form-label">&nbsp;</label>


                  <input type="date" class="form-control" name="employee_from_service_period[]" id="employee_from_service_period" placeholder="Service Period (From) 2"/>


                </div>


                <div class="col-lg-2">


                  <label class="form-label">&nbsp;</label>


                  <input type="date" class="form-control" name="employee_to_service_period[]" id="employee_to_service_period" placeholder="Service Period (To) 2"/>


                </div>


                <div class="col-lg-2">


                  <label class="form-label">&nbsp;</label>


                  <input type="text" class="form-control" name="employee_ctc[]" id="employee_ctc" placeholder="Annual CTC 2"/>


                </div>


              </div>


            </div>


          </div>


          


          <div class="card mb-4">


            <div class="card-body">


              <h3 class="h6 mb-4">Family Details</h3>


              <div class="row">


                <div class="col-lg-3">


                  <label class="form-label">Name</label>


                  <input type="text" class="form-control textonly" name="family_name[]" id="family_name" placeholder="Name 1"/>


                </div>


                <div class="col-lg-3">


                  <label class="form-label">Relation</label>


                  <input type="text" class="form-control" name="family_relation[]" id="family_relation" placeholder="Relation 2"/>


                </div>


                <div class="col-lg-3">


                  <label class="form-label">Occupation</label>


                  <input type="text" class="form-control" name="family_occupation[]" id="family_occupation" placeholder="Occupation 3"/>


                </div>


                <div class="col-lg-3">


                  <label class="form-label">Date of Birth</label>


                  <input type="date" class="form-control" name="family_dob[]" id="family_dob" placeholder="Date of Birth 4"/>


                </div>


              </div>


              @for($i=1;$i<=4;$i++)


              <div class="row">


                <div class="col-lg-3">


                  <label class="form-label">&nbsp;</label>


                  <input type="text" class="form-control textonly" name="family_name[]" id="family_name" placeholder="Name {{$i+1}}"/>


                </div>


                <div class="col-lg-3">


                  <label class="form-label">&nbsp;</label>


                  <input type="text" class="form-control" name="family_relation[]" id="family_relation" placeholder="Relation {{$i+1}}"/>


                </div>


                <div class="col-lg-3">


                  <label class="form-label">&nbsp;</label>


                  <input type="text" class="form-control" name="family_occupation[]" id="family_occupation" placeholder="Occupation {{$i+1}}"/>


                </div>


                <div class="col-lg-3">


                  <label class="form-label">&nbsp;</label>


                  <input type="date" class="form-control" name="family_dob[]" id="family_dob" placeholder="Date of Birth {{$i+1}}"/>


                </div>


              </div>


              @endfor 


            </div>


          </div>


          


          <div class="card mb-4">


            <div class="card-body">


              <h3 class="h6 mb-4">Professional References</h3>


              <div class="row">


                <div class="col-lg-6">


                  <div class="col-lg-12">


                    <label class="form-label required">Reference 1</label>


                    <input type="text" class="form-control textonly professional_name" onkeyup="$('#professional_nameError').remove()" name="professional_name[]" id="professional_name" placeholder="Name 1"/>


                  </div>


                  <div class="col-lg-12">


                    <label class="form-label">&nbsp;</label>


                    <input type="text" class="form-control professional_organisation" onkeyup="$('#professional_organisationError').remove()" name="professional_organisation[]" id="professional_organisation" placeholder="Organisation 1"/>


                  </div>


                  <div class="col-lg-12">


                    <label class="form-label">&nbsp;</label>


                    <input type="text" class="form-control professional_designation" onkeyup="$('#professional_designationError').remove()" name="professional_designation[]" id="professional_designation" placeholder="Designation 1"/>


                  </div>


                  <div class="col-lg-12">


                    <label class="form-label">&nbsp;</label>


                    <input type="tel" class="form-control professional_contact numberonly" onkeyup="$('#professional_contactError').remove()" name="professional_contact[]" id="professional_contact" maxlength="10" placeholder="Contact Number 1"/>


                  </div>


                </div>


                <div class="col-lg-6">


                  <div class="col-lg-12">


                    <label class="form-label required">Reference 2</label>


                    <input type="text" class="form-control textonly professional_name" onkeyup="$('#professional_nameError').remove()" name="professional_name[]" id="professional_name" placeholder="Name 2"/>


                  </div>


                  <div class="col-lg-12">


                    <label class="form-label">&nbsp;</label>


                    <input type="text" class="form-control professional_organisation" onkeyup="$('#professional_organisationError').remove()" name="professional_organisation[]" id="professional_organisation" placeholder="Organisation 2"/>


                  </div>


                  <div class="col-lg-12">


                    <label class="form-label">&nbsp;</label>


                    <input type="text" class="form-control professional_designation" onkeyup="$('#professional_designationError').remove()" name="professional_designation[]" id="professional_designation" placeholder="Designation 2"/>


                  </div>


                  <div class="col-lg-12">


                    <label class="form-label">&nbsp;</label>


                    <input type="tel" class="form-control professional_contact numberonly" onkeyup="$('#professional_contactError').remove()" name="professional_contact[]" maxlength="10" id="professional_contact" placeholder="Contact Number 2"/>


                  </div>


                </div>


              </div>


            </div>


          </div>


          


          <div class="card mb-4">


            <div class="card-body">


              <h3 class="h6 mb-4">Declaration</h3>


              <div class="row">


                <div class="col-lg-12">


                  <input type="checkbox" id="checkbox" name="checkbox" value="1"/>


                  &nbsp;


                  


                  I hereby declare that the above statments made in my application form are true, complete and correct to the best of my knowledge and belief. 


                  


                  In the event of any information being found false or incorrect at any stage, my services are liable to be terminated without notice. </div>


              </div>


              <div class="row">


                <div class="col-lg-12">


                  <div class="pt-3 text-center">                     


                    <!--begin::Submit button-->                    


                    <button type="button" id="employee_register_btn" class="btn btn-sm btn-info fw-bolder me-3 my-2"> <span class="indicator-label" id="formSubmit">Register Now</span> <span class="indicator-progress d-none">Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span> </span> </button>


                  </div>


                </div>


              </div>


            </div>


          </div>


        </div>


      </form>


    </div>


  </div>


</div>


<script>


	let saveDataURL = "{{url('save-employee/')}}";


	$(document).ready(function(){


		$('.numberonly').keypress(function(e){


			var charCode = (e.which) ? e.which : event.keyCode


			if(String.fromCharCode(charCode).match(/[^0-9+]/g))


			return false;


		});


		$('.textonly').keypress(function(e){


			var charCode = (e.which) ? e.which : event.keyCode


			if(String.fromCharCode(charCode).match(/[^a-z A-Z+]/g))


			return false;


		});	





		var formSubmitted = false;


		$('#employee_register_btn').click(function(e){


			var flag = 0;


			if(!formSubmitted){


				formSubmitted = false;


				var validateMobNum= /^\d*(?:\.\d{1,2})?$/;


				var telephoneNum = $.trim($("#telephone").val());


				var mobileNum = $.trim($("#mobile").val());


				var EcontactNum = $.trim($("#emergency_contact").val());


				var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;


				if($.trim($("#first_name").val()) == ''){


					flag = 1;


					$("#first_name").focus();


					swal("Error!", 'Please Enter First Name.', "error");					


					return false;


				}


			  	/*if($.trim($("#last_name").val()) == ''){


					flag = 1;


					$("#last_name").focus();


					swal("Error!", 'Please Enter Last Name.', "error");


					return false;


				}*/


				if($.trim($("#father_name").val()) == ''){


					flag = 1;


					$("#father_name").focus();


					swal("Error!", 'Please Enter Father Name.', "error");


					return false;


				}


				if($.trim($("#profile").val()) == ''){


					flag = 1;


					$("#profile").focus();


					swal("Error!", 'Please Enter Profile Photo.', "error");


					return false;


				}


				if($.trim($("#aadhaar").val()) == ''){


					flag = 1;


					$("#aadhaar").focus();


					swal("Error!", 'Please Enter Aadhaar Card.', "error");


					return false;


				}


				if($.trim($("#correspondence_address").val()) == ''){


					flag = 1;


					$("#correspondence_address").focus();


					swal("Error!", 'Please Enter Correspondence Address.', "error");


					return false;


				}


				if($.trim($("#permanent_address").val()) == ''){


					flag = 1;


					$("#permanent_address").focus();


					swal("Error!", 'Please Enter Permanent Address.', "error");


					return false;


				}


				if($.trim($("#telephone").val()) == ''){


					flag = 1;


					$("#telephone").focus();


					swal("Error!", 'Please Enter Telephone Number.', "error");


					return false;


				}else{


					if(validateMobNum.test(telephoneNum) && telephoneNum.length == 10){							


					}else{


						flag = 1;


						$("#telephone").focus();


						swal("Error!", 'Please Enter Valid Telephone Number.', "error");


						return false;	


					}


				}


				if($.trim($("#mobile").val()) == ''){


					flag = 1;


					$("#mobile").focus();


					swal("Error!", 'Please Enter Mobile Number.', "error");


					return false;


				}else{


					if(validateMobNum.test(mobileNum) && mobileNum.length == 10){							


					}else{


						flag = 1;


						$("#mobile").focus();


						swal("Error!", 'Please Enter Valid Mobile Number.', "error");


						return false;	


					}


				}


				if($.trim($("#email").val()) == ''){


					flag = 1;


					$("#email").focus();


					swal("Error!", 'Please Enter Email Address.', "error");


					return false;


				}else{


					if(!regex.test($.trim($("#email").val()))){


						flag = 1;


						$("#email").focus();


						swal("Error!", 'Please Enter Valid Email Address.', "error");


						return false;	


					}


				}


				if($.trim($("#dob").val()) == ''){


					flag = 1;


					$("#dob").focus();


					swal("Error!", 'Please Enter Date of Birth.', "error");


					return false;


				}


				if($.trim($("#pan_card").val()) == ''){


					flag = 1;


					$("#pan_card").focus();


					swal("Error!", 'Please Enter PAN Card Number.', "error");


					return false;


				}


				if($.trim($("#emergency_name").val()) == ''){


					flag = 1;


					$("#emergency_name").focus();


					swal("Error!", 'Please Enter Emergency Contact Name.', "error");


					return false;


				}


				if($.trim($("#emergency_relation").val()) == ''){


					flag = 1;


					$("#emergency_relation").focus();


					swal("Error!", 'Please Enter Emergency Contact Relation.', "error");


					return false;


				}


				if($.trim($("#emergency_contact").val()) == ''){


					flag = 1;


					$("#emergency_contact").focus();


					swal("Error!", 'Please Enter Emergency Contact Number.', "error");


					return false;


				}else{


					if(validateMobNum.test(EcontactNum) && EcontactNum.length == 10){							


					}else{


						flag = 1;


						$("#emergency_contact").focus();


						swal("Error!", 'Please Enter Valid Emergency Contact Number.', "error");


						return false;	


					}


				}	


				if($.trim($("#account_no").val()) == ''){


					flag = 1;


					$("#account_no").focus();


					swal("Error!", 'Please Enter Account Number.', "error");


					return false;


				}


				if($.trim($("#ifsc").val()) == ''){


					flag = 1;


					$("#ifsc").focus();


					swal("Error!", 'Please Enter IFSC Code.', "error");


					return false;


				}


				if($.trim($("#bank_name").val()) == ''){


					flag = 1;


					$("#bank_name").focus();


					swal("Error!", 'Please Enter Bank Name.', "error");


					return false;


				}


				if($.trim($("#account_holder_name").val()) == ''){


					flag = 1;


					$("#account_holder_name").focus();


					swal("Error!", 'Please Enter Account Holder Name.', "error");


					return false;


				}


				if($.trim($("#account_image").val()) == ''){


					flag = 1;


					$("#account_image").focus();


					swal("Error!", 'Please Enter Account Image.', "error");


					return false;


				}		


				 


				$(".professional_contact").each(function(index, element){


					if($(this).val() == ''){


						flag = 1;


						$("#professional_contact").focus();


						swal("Error!", 'Please Enter Professional Reference Contact.', "error");


						return false;


					}


				});


				$(".professional_designation").each(function(index, element){


					if($(this).val() == ''){


						flag = 1;


						$("#professional_designation").focus();


						swal("Error!", 'Please Enter Professional Reference Designation.', "error");


						return false;


					}


				});


				$(".professional_organisation").each(function(index, element){


					if($(this).val() == ''){


						flag = 1;


						$("#professional_organisation").focus();


						swal("Error!", 'Please Enter Professional Reference Organisation.', "error");


						return false;


					}


				});


				$(".professional_name").each(function(index, element){


					if($(this).val() == ''){


						flag = 1;


						$("#professional_name").focus();


						swal("Error!", 'Please Enter Professional Reference Name.', "error");


						return false;	


					}


				});


				


				if($('input[type="checkbox"]').prop("checked") == false){


					flag = 1;


					swal("Error!", 'Please Check Terms & Conditions.', "error");


					return false;


				}


				if(flag == 0){


					$('#employee_register_btn .indicator-label').addClass('d-none');


					$('#employee_register_btn .indicator-progress').removeClass('d-none');


					var form = $('#pageForm')[0];


					var formData = new FormData(form);


					console.log(formData);


					formSubmitted = true;


					$.ajax({


						type: 'POST',


						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},


						url: saveDataURL,


						data: formData,


						processData: false,


						contentType: false,


						success: function(response){


							console.log(response);


							$('.field_error').remove();


							if (response.status == 'error'){


								swal("Error!", 'Error on send inquiry.', "error");


								if(response['errors'] != ''){


									$.each(response['errors'], function(key, value){


										$("."+key).slideDown('slow').after().show(0);


										var flag = $('#'+key).parents('.form:first').find('div:first').length;


										if(flag == 0){


											var error_html = '<div class="field_error" id="'+key+'Error" for="'+key+'" generated="true" style="text-align: left;display: inline-block;">'+value+'</div>';


											$("."+key).slideDown('slow').after(error_html);


										}else{


											$("."+key).parents('.form:first').find('div:first').html(value).show(0);


										}


									});


									$('#first_name').focus();


								}


							}else{


								$($('#pageForm')[0].reset());


								swal("Success!", 'Employee Register Successfully.', "success");


								$('#first_name').focus();


							}


							formSubmitted = false;


							$('#employee_register_btn .indicator-label').removeClass('d-none');


							$('#employee_register_btn .indicator-progress').addClass('d-none');


						},error: function(ts) {


							console.log(ts);


							formSubmitted = false;


							$('#employee_register_btn .indicator-label').removeClass('d-none');


							$('#employee_register_btn .indicator-progress').addClass('d-none');


							swal("Error!", 'Something went wrong, please try after sometime.', "error");


							return false;


						}


					});


				}


			}


		});


	});


</script> 


@endsection