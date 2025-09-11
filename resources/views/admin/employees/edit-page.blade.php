@extends('layout.admin.dashboard')
@section('content')
<div class="page-heading">
   <div class="page-title">
      <div class="row">
         <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Edit Employee</h3>
         </div>
         <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="{{url('/admin/employees')}}">Employee</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Edit Employee</li>
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
                     <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation"> <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home"
                           role="tab" aria-controls="home" aria-selected="true">Personal Info</a> </li>
                        <li class="nav-item" role="presentation"> <a class="nav-link" id="education-tab" data-bs-toggle="tab" href="#education"
                           role="tab" aria-controls="education" aria-selected="true">Educational Details</a> </li>
                        <li class="nav-item" role="presentation"> <a class="nav-link" id="employee-tab" data-bs-toggle="tab" href="#employee"
                           role="tab" aria-controls="employee" aria-selected="true">Employee Details</a> </li>
                        <li class="nav-item" role="presentation"> <a class="nav-link" id="account-tab" data-bs-toggle="tab" href="#account"
                           role="tab" aria-controls="account" aria-selected="true">Account Details</a> </li>
                        <li class="nav-item" role="presentation"> <a class="nav-link" id="family-tab" data-bs-toggle="tab" href="#family"
                           role="tab" aria-controls="family" aria-selected="true">Family Details</a> </li>
                        <li class="nav-item" role="presentation"> <a class="nav-link" id="professional-tab" data-bs-toggle="tab" href="#professional"
                           role="tab" aria-controls="professional" aria-selected="true">Professional Reference</a> </li>
                     </ul>
                     <hr />
                     <div class="tab-content mt-5" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                           <div class="row">
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Employee ID</label>
                                    <input type="text" class="form-control emp_id" value="{{$rowData->emp_id}}" onkeyup="$('#emp_idError').remove()" name="emp_id" id="emp_id" placeholder="Employee ID">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">First Name</label>
                                    <input type="text" class="form-control first_name textonly" value="{{$rowData->first_name}}" onkeyup="$('#first_nameError').remove()" name="first_name" id="first_name" placeholder="First name">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Middle Name</label>
                                    <input type="text" class="form-control middle_name textonly" value="{{$rowData->middle_name}}" onkeyup="$('#middle_nameError').remove()" name="middle_name" id="middle_name" placeholder="Middle name"/>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Last Name</label>
                                    <input type="text" class="form-control last_name textonly" value="{{$rowData->last_name}}" onkeyup="$('#last_nameError').remove()" name="last_name" id="last_name" placeholder="Last Name"/>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Salary</label>
                                    <input type="text" class="form-control salary numberonly" value="{{$rowData->salary}}" onkeyup="$('#salaryError').remove()" name="salary" id="salary" placeholder="Salary"/>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Father Name</label>
                                    <input type="text" class="form-control father_name textonly" value="{{$rowData->father_name}}" onkeyup="$('#father_nameError').remove()" name="father_name" id="father_name" placeholder="Father Name"/>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Profile Photo</label>
                                    <input class="form-control profile" onclick="$('#profileError').remove()" type="file" name="profile" id="profile">
                                 </div>
                              </div>
                              @if($rowData->profile != "")
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="basicInput">&nbsp;</label>
                                    <a target="_blank" href="{{URL::asset('public/admin/images/users/')}}/{!! $rowData->profile !!}"><img src="{{URL::asset('public/admin/images/users/')}}/{!! $rowData->profile !!}" style="max-width:90px;height: auto;"></a>
                                 </div>
                              </div>
                              @endif
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Aadhaar Card</label>
                                    <input class="form-control aadhaar" onclick="$('#aadhaarError').remove()" type="file" name="aadhaar" id="aadhaar">
                                 </div>
                              </div>
                              @if($rowData->aadhaar != "")
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="basicInput">&nbsp;</label>
                                    <a target="_blank" href="{{URL::asset('public/admin/images/users/')}}/{!! $rowData->aadhaar !!}"><img src="{{URL::asset('public/admin/images/users/')}}/{!! $rowData->aadhaar !!}" style="max-width:90px;height: auto;"></a>
                                 </div>
                              </div>
                              @endif
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="basicInput">Correspondence Address</label>
                                    <input type="text" class="form-control correspondence_address" value="{{$rowData->correspondence_address}}" onkeyup="$('#correspondence_addressError').remove()" name="correspondence_address" id="correspondence_address" placeholder="Correspondence Address"/>
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="basicInput">Permanent Address</label>
                                    <input type="text" class="form-control permanent_address" value="{{$rowData->permanent_address}}" onkeyup="$('#permanent_addressError').remove()" name="permanent_address" id="permanent_address" placeholder="Permanent Address"/>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Telephone</label>
                                    <input type="tel" class="form-control numberonly telephone" value="{{$rowData->telephone}}" onkeyup="$('#telephoneError').remove()" name="telephone" maxlength="10" id="telephone" placeholder="Telephone"/>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Mobile</label>
                                    <input type="tel" class="form-control numberonly mobile" value="{{$rowData->mobile}}" onkeyup="$('#mobileError').remove()" name="mobile" maxlength="10" id="mobile" placeholder="Mobile"/>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Email</label>
                                    <input type="text" class="form-control email" name="email" value="{{$rowData->email}}" onkeyup="$('#emailError').remove()" id="email" placeholder="Email"/>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Password</label>
                                    <input type="text" class="form-control password" name="password" value="{{$rowData->temp_password}}" onkeyup="$('#passwordError').remove()" id="password" placeholder="Password"/>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Date of Birth</label>
                                    @php
                                    $afterdate = date('Y-m-d', strtotime('-18 year'));
                                    @endphp
                                    <input type="date" class="form-control dob" max="{{$afterdate}}" value="{{$rowData->dob}}" onclick="$('#dobError').remove()" name="dob" id="dob" placeholder="Date of Birth"/>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Marital Status</label>
                                    <select class="form-control" name="marital_status" id="marital_status"/>                  
                                    <option {{$rowData->marital_status == 'Single'?'selected':''}} value="Single">Single</option>
                                    <option {{$rowData->marital_status == 'Married'?'selected':''}} value="Married">Married</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">PAN Card</label>
                                    <input type="text" class="form-control pan_card" name="pan_card" value="{{$rowData->pan_card}}" onkeyup="$('#pan_cardError').remove()" id="pan_card" placeholder="PAN Card"/>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Blood Group</label>
                                    <input type="text" class="form-control" name="blood_group" value="{{$rowData->blood_group}}" onkeyup="$('#blood_groupError').remove()" id="blood_group" placeholder="Blood Group"/>
                                 </div>
                              </div>
                              <div class="col-lg-12">
                                 <h6 class="mb-2">Emergency Contact Details</h6>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Name</label>
                                    <input type="text" class="form-control emergency_name textonly" value="{{$rowData->emergency_name}}" onkeyup="$('#emergency_nameError').remove()" name="emergency_name" id="emergency_name" placeholder="Name"/>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Relation</label>
                                    <input type="text" class="form-control emergency_relation" value="{{$rowData->emergency_relation}}" onkeyup="$('#emergency_relationError').remove()" name="emergency_relation" id="emergency_relation" placeholder="Relation"/>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Contact No</label>
                                    <input type="tel" class="form-control numberonly emergency_contact" value="{{$rowData->emergency_contact}}" onkeyup="$('#emergency_contactError').remove()" name="emergency_contact" maxlength="10" id="emergency_contact" placeholder="Contact No"/>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane fade " id="education" role="tabpanel" aria-labelledby="education-tab">
                           @if($rowData->education_degree != '')
                           @php
                           $education_degree_explode = explode('|',$rowData->education_degree);
                           $education_university_explode = explode('|',$rowData->education_university);
                           $education_from_explode = explode('|',$rowData->education_from);
                           $education_to_explode = explode('|',$rowData->education_to);
                           $education_percentage_explode = explode('|',$rowData->education_percentage);
                           $education_specialization_explode = explode('|',$rowData->education_specialization);
                           @endphp
                           @foreach($education_degree_explode as $key => $degree)
                           <div class="row">
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="basicInput">Degree</label>
                                    <input type="text" class="form-control" name="education_degree[]" value="{{$degree}}" id="education_degree" placeholder="Degree 1"/>
                                 </div>
                              </div>
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="basicInput">University/Institute</label>
                                    <input type="text" class="form-control" name="education_univesity[]" value="{{$education_university_explode[$key]}}" id="education_univesity" placeholder="University/Institute 1"/>
                                 </div>
                              </div>
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="basicInput">From</label>
                                    <input type="date" class="form-control" name="education_from[]" value="{{$education_from_explode[$key]}}" id="education_from" placeholder="From 1"/>
                                 </div>
                              </div>
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="basicInput">To</label>
                                    <input type="date" class="form-control" name="education_to[]" value="{{$education_to_explode[$key]}}" id="education_to" placeholder="To 1"/>
                                 </div>
                              </div>
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="basicInput">Percentage/Grade</label>
                                    <input type="text" class="form-control" name="education_percentage[]" value="{{$education_percentage_explode[$key]}}" id="education_percentage" placeholder="Percentage/Grade 1"/>
                                 </div>
                              </div>
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="basicInput">Specialization</label>
                                    <input type="text" class="form-control" name="education_specialization[]" value="{{$education_specialization_explode[$key]}}" id="education_specialization" placeholder="Specialization 1"/>
                                 </div>
                              </div>
                           </div>
                           @endforeach
                           @endif                  
                        </div>
                        <div class="tab-pane fade " id="employee" role="tabpanel" aria-labelledby="employee-tab">
                           @if($rowData->employee_organisation != '')
                           @php
                           $employee_organisation_explode = explode('|',$rowData->employee_organisation);
                           $employee_designation_explode = explode('|',$rowData->employee_designation);
                           $employee_from_service_period_explode = explode('|',$rowData->employee_from_service_period);
                           $employee_to_service_period_explode = explode('|',$rowData->employee_to_service_period);
                           $employee_ctc_explode = explode('|',$rowData->employee_ctc);
                           @endphp
                           @foreach($employee_organisation_explode as $key => $eorganisation)
                           <div class="row">
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="basicInput">Organisation</label>
                                    <input type="text" class="form-control" name="employee_organisation[]" value="{{$eorganisation}}" id="employee_organisation" placeholder="Organisation 1"/>
                                 </div>
                              </div>
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="basicInput">Designation</label>
                                    <input type="text" class="form-control" name="employee_designation[]" value="{{$employee_designation_explode[$key]}}" id="employee_designation" placeholder="Designation 1"/>
                                 </div>
                              </div>
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="basicInput">Service Period (From)</label>
                                    <input type="date" class="form-control" name="employee_from_service_period[]" value="{{$employee_from_service_period_explode[$key]}}" id="employee_from_service_period" placeholder="Service Period (From) 1"/>
                                 </div>
                              </div>
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="basicInput">Service Period (To)</label>
                                    <input type="date" class="form-control" name="employee_to_service_period[]" value="{{$employee_to_service_period_explode[$key]}}" id="employee_to_service_period" placeholder="Service Period (To) 1"/>
                                 </div>
                              </div>
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="basicInput">Annual CTC</label>
                                    <input type="text" class="form-control" name="employee_ctc[]" id="employee_ctc" value="{{$employee_ctc_explode[$key]}}" placeholder="Annual CTC 1"/>
                                 </div>
                              </div>
                           </div>
                           @endforeach
                           @endif
                        </div>
                        <div class="tab-pane fade " id="account" role="tabpanel" aria-labelledby="account-tab">
                           <div class="row">
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Account Number</label>
                                    <input type="text" class="form-control account_no numberonly" maxlength="20" value="{{$rowData->account_no}}" onkeyup="$('#account_noError').remove()" name="account_no" id="account_no" placeholder="Account Number">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">IFSC</label>
                                    <input type="text" class="form-control ifsc" onkeyup="$('#ifscError').remove()" value="{{$rowData->ifsc}}" name="ifsc" id="ifsc" placeholder="IFSC"/>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Bank Name</label>
                                    <input type="text" class="form-control bank_name" onkeyup="$('#bank_nameError').remove()" value="{{$rowData->bank_name}}" name="bank_name" id="bank_name" placeholder="Bank Name"/>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Acount Holder Name</label>
                                    <input type="text" class="form-control account_holder_name textonly" name="account_holder_name" value="{{$rowData->account_holder_name}}" onkeyup="$('#account_holder_nameError').remove()"  id="account_holder_name" placeholder="Acount Holder Name"/>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Account Image</label>
                                    <input class="form-control account_image" onclick="$('#account_imageError').remove()" type="file" name="account_image" id="account_image">
                                 </div>
                              </div>
                              @if($rowData->account_image != "")
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="basicInput">&nbsp;</label>
                                    <a target="_blank" href="{{URL::asset('public/admin/images/users/')}}/{!! $rowData->account_image !!}"><img src="{{URL::asset('public/admin/images/users/')}}/{!! $rowData->account_image !!}" style="max-width:90px;height: auto;"></a>
                                 </div>
                              </div>
                              @endif
                           </div>
                        </div>
                        <div class="tab-pane fade " id="family" role="tabpanel" aria-labelledby="family-tab">
                           @if($rowData->family_name != '')
                           @php
                           $family_name_explode = explode('|',$rowData->family_name);
                           $family_relation_explode = explode('|',$rowData->family_relation);
                           $family_occupation_explode = explode('|',$rowData->family_occupation);
                           $family_dob_explode = explode('|',$rowData->family_dob);
                           @endphp
                           @foreach($family_name_explode as $key => $family_name)
                           <div class="row">
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="basicInput">Name</label>
                                    <input type="text" class="form-control textonly" name="family_name[]" value="{{$family_name}}" id="family_name" placeholder="Name 1"/>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="basicInput">Relation</label>
                                    <input type="text" class="form-control" name="family_relation[]" value="{{$family_relation_explode[$key]}}" id="family_relation" placeholder="Relation 2"/>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="basicInput">Occupation</label>
                                    <input type="text" class="form-control" name="family_occupation[]" value="{{$family_occupation_explode[$key]}}" id="family_occupation" placeholder="Occupation 3"/>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="basicInput">Date of Birth</label>
                                    <input type="date" class="form-control" name="family_dob[]" value="{{$family_dob_explode[$key]}}" id="family_dob" placeholder="Date of Birth 4"/>
                                 </div>
                              </div>
                           </div>
                           @endforeach
                           @endif
                        </div>
                        <div class="tab-pane fade " id="professional" role="tabpanel" aria-labelledby="professional-tab">
                           @if($rowData->professional_name != '')
                           <div class="row">
                              @php
                              $professional_name_explode = explode('|',$rowData->professional_name);
                              $professional_organisation_explode = explode('|',$rowData->professional_organisation);
                              $professional_designation_explode = explode('|',$rowData->professional_designation);
                              $professional_contact_explode = explode('|',$rowData->professional_contact);
                              @endphp
                              @foreach($professional_name_explode as $key => $professional_name)
                              <div class="col-lg-6">
                                 <div class="col-lg-12">
                                    <label class="form-label required">Reference {{$key+1}}</label>
                                    <input type="text" class="form-control textonly professional_name" value="{{$professional_name}}" onkeyup="$('#professional_nameError').remove()" name="professional_name[]" id="professional_name" placeholder="Name {{$key+1}}"/>
                                 </div>
                                 <div class="col-lg-12">
                                    <label class="form-label">&nbsp;</label>
                                    <input type="text" class="form-control professional_organisation" value="{{$professional_organisation_explode[$key]}}" onkeyup="$('#professional_organisationError').remove()" name="professional_organisation[]" id="professional_organisation" placeholder="Organisation {{$key+1}}"/>
                                 </div>
                                 <div class="col-lg-12">
                                    <label class="form-label">&nbsp;</label>
                                    <input type="text" class="form-control professional_designation" value="{{$professional_designation_explode[$key]}}" onkeyup="$('#professional_designationError').remove()" name="professional_designation[]" id="professional_designation" placeholder="Designation {{$key+1}}"/>
                                 </div>
                                 <div class="col-lg-12">
                                    <label class="form-label">&nbsp;</label>
                                    <input type="tel" class="form-control professional_contact numberonly" value="{{$professional_contact_explode[$key]}}" onkeyup="$('#professional_contactError').remove()" name="professional_contact[]" id="professional_contact" maxlength="10" placeholder="Contact Number {{$key+1}}"/>
                                 </div>
                              </div>
                              @endforeach
                           </div>
                           @endif
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-3 col-md-3 ">
               <div class="card">
                  <div class="col-md-12">
                     <div class="text-left  p-3 p-l-20">
                        <!--begin::Submit button-->
                        <button type="button" id="form_submit" class="btn btn-sm btn-primary fw-bolder me-3 my-2"> <span class="indicator-label" id="formSubmit">Submit</span> <span class="indicator-progress d-none">Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span> </span> </button>
                        <!--end::Submit button--> 
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </section>
</div>
<!-- end plugin js --> 
<script>
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

  });   
  let saveDataURL = "{{url('/admin/edit-employee/'.$row_id)}}";   
  let returnURL = "{{url('/admin/employees')}}";   
</script>
<script src="{{ asset('public/admin/js/pages/employees/edit-page.js') }}"></script>
@endsection