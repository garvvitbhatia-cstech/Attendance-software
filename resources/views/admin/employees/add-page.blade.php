@extends('layout.admin.dashboard')
@section('content')

<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>Add Employee</h3>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{url('/admin/employees')}}">Employee</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Employee</li>
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
                        <label for="basicInput">First Name</label>
                        <input type="text" class="form-control first_name textonly" value="" onkeyup="$('#first_nameError').remove()" name="first_name" id="first_name" placeholder="First name">
                      </div>
                    </div>                    
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="basicInput">Middle Name</label>
                        <input type="text" class="form-control middle_name textonly" value="" onkeyup="$('#middle_nameError').remove()" name="middle_name" id="middle_name" placeholder="Middle name"/>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="basicInput">Last Name</label>
                        <input type="text" class="form-control last_name textonly" value="" onkeyup="$('#last_nameError').remove()" name="last_name" id="last_name" placeholder="Last Name"/>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="basicInput">Father Name</label>
                        <input type="email" class="form-control father_name textonly" value="" onkeyup="$('#father_nameError').remove()" name="father_name" id="father_name" placeholder="Father Name"/>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="basicInput">Profile Photo</label>
                        <input class="form-control profile" onclick="$('#profileError').remove()" type="file" name="profile" id="profile">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="basicInput">Aadhaar Card</label>
                        <input class="form-control aadhaar" onclick="$('#aadhaarError').remove()" type="file" name="aadhaar" id="aadhaar">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="basicInput">Correspondence Address</label>
                        <input type="text" class="form-control correspondence_address" value="" onkeyup="$('#correspondence_addressError').remove()" name="correspondence_address" id="correspondence_address" placeholder="Correspondence Address"/>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="basicInput">Permanent Address</label>
                        <input type="text" class="form-control permanent_address" value="" onkeyup="$('#permanent_addressError').remove()" name="permanent_address" id="permanent_address" placeholder="Permanent Address"/>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="basicInput">Telephone</label>
                        <input type="tel" class="form-control numberonly telephone" value="" onkeyup="$('#telephoneError').remove()" name="telephone" maxlength="10" id="telephone" placeholder="Telephone"/>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="basicInput">Mobile</label>
                        <input type="tel" class="form-control numberonly mobile" value="" onkeyup="$('#mobileError').remove()" name="mobile" maxlength="10" id="mobile" placeholder="Mobile"/>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="basicInput">Email</label>
                        <input type="text" class="form-control email" name="email" value="" onkeyup="$('#emailError').remove()" id="email" placeholder="Email"/>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="basicInput">Date of Birth</label>
                        @php
                        $afterdate = date('Y-m-d', strtotime('-18 year'));
                      	@endphp
                        <input type="date" class="form-control dob" max="{{$afterdate}}" value="" onclick="$('#dobError').remove()" name="dob" id="dob" placeholder="Date of Birth"/>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="basicInput">Marital Status</label>
                        <select class="form-control" name="marital_status" id="marital_status"/>                  
                          <option value="Single">Single</option>
                          <option value="Married">Married</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="basicInput">PAN Card</label>
                        <input type="text" class="form-control pan_card" name="pan_card" value="" onkeyup="$('#pan_cardError').remove()" id="pan_card" placeholder="PAN Card"/>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="basicInput">Blood Group</label>
                        <input type="text" class="form-control" name="blood_group" value="" onkeyup="$('#blood_groupError').remove()" id="blood_group" placeholder="Blood Group"/>
                      </div>
                    </div>
                    <div class="col-lg-12">
                    <h6 class="mb-2">Emergency Contact Details</h6>
                  </div>
                  
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="basicInput">Name</label>
                        <input type="text" class="form-control emergency_name textonly" value="" onkeyup="$('#emergency_nameError').remove()" name="emergency_name" id="emergency_name" placeholder="Name"/>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="basicInput">Relation</label>
                        <input type="text" class="form-control emergency_relation" value="" onkeyup="$('#emergency_relationError').remove()" name="emergency_relation" id="emergency_relation" placeholder="Relation"/>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="basicInput">Contact No</label>
                        <input type="tel" class="form-control numberonly emergency_contact" value="" onkeyup="$('#emergency_contactError').remove()" name="emergency_contact" maxlength="10" id="emergency_contact" placeholder="Contact No"/>
                      </div>
                    </div>
                    
                    </div>                     
                </div>
                 
                <div class="tab-pane fade " id="education" role="tabpanel" aria-labelledby="education-tab">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">Degree</label>
                        <input type="text" class="form-control" name="education_degree[]" id="education_degree" placeholder="Degree 1"/>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">University/Institute</label>
                        <input type="text" class="form-control" name="education_univesity[]" id="education_univesity" placeholder="University/Institute 1"/>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">From</label>
                        <input type="date" class="form-control" name="education_from[]" id="education_from" placeholder="From 1"/>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">To</label>
                        <input type="date" class="form-control" name="education_to[]" id="education_to" placeholder="To 1"/>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">Percentage/Grade</label>
                        <input type="text" class="form-control" name="education_percentage[]" id="education_percentage" placeholder="Percentage/Grade 1"/>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">Specialization</label>
                        <input type="text" class="form-control" name="education_specialization[]" id="education_specialization" placeholder="Specialization 1"/>
                      </div>
                    </div>                    
                  </div>
                  
                  @for($i=1;$i<=4;$i++)
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">Degree</label>
                        <input type="text" class="form-control" name="education_degree[]" id="education_degree" placeholder="Degree {{$i+1}}"/>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">University/Institute</label>
                        <input type="text" class="form-control" name="education_univesity[]" id="education_univesity" placeholder="University/Institute {{$i+1}}"/>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">From</label>
                        <input type="date" class="form-control" name="education_from[]" id="education_from" placeholder="From {{$i+1}}"/>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">To</label>
                        <input type="date" class="form-control" name="education_to[]" id="education_to" placeholder="To {{$i+1}}"/>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">Percentage/Grade</label>
                        <input type="text" class="form-control" name="education_percentage[]" id="education_percentage" placeholder="Percentage/Grade {{$i+1}}"/>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">Specialization</label>
                        <input type="text" class="form-control" name="education_specialization[]" id="education_specialization" placeholder="Specialization {{$i+1}}"/>
                      </div>
                    </div>
                    
                  </div>
                  @endfor
                  
                </div>
                
                <div class="tab-pane fade " id="employee" role="tabpanel" aria-labelledby="employee-tab">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">Organisation</label>
                        <input type="text" class="form-control" name="employee_organisation[]" id="employee_organisation" placeholder="Organisation 1"/>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">Designation</label>
                        <input type="text" class="form-control" name="employee_designation[]" id="employee_designation" placeholder="Designation 1"/>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">Service Period (From)</label>
                        <input type="date" class="form-control" name="employee_from_service_period[]" id="employee_from_service_period" placeholder="Service Period (From) 1"/>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">Service Period (To)</label>
                        <input type="date" class="form-control" name="employee_to_service_period[]" id="employee_to_service_period" placeholder="Service Period (To) 1"/>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">Annual CTC</label>
                        <input type="text" class="form-control" name="employee_ctc[]" id="employee_ctc" placeholder="Annual CTC 1"/>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">&nbsp;</label>
                        <input type="text" class="form-control" name="employee_organisation[]" id="employee_organisation" placeholder="Organisation 1"/>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">&nbsp;</label>
                        <input type="text" class="form-control" name="employee_designation[]" id="employee_designation" placeholder="Designation 1"/>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">&nbsp;</label>
                        <input type="date" class="form-control" name="employee_from_service_period[]" id="employee_from_service_period" placeholder="Service Period (From) 1"/>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">&nbsp;</label>
                        <input type="date" class="form-control" name="employee_to_service_period[]" id="employee_to_service_period" placeholder="Service Period (To) 1"/>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">&nbsp;</label>
                        <input type="text" class="form-control" name="employee_ctc[]" id="employee_ctc" placeholder="Annual CTC 1"/>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="tab-pane fade " id="family" role="tabpanel" aria-labelledby="family-tab">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="basicInput">Name</label>
                        <input type="text" class="form-control textonly" name="family_name[]" id="family_name" placeholder="Name 1"/>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="basicInput">Relation</label>
                        <input type="text" class="form-control" name="family_relation[]" id="family_relation" placeholder="Relation 2"/>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="basicInput">Occupation</label>
                        <input type="text" class="form-control" name="family_occupation[]" id="family_occupation" placeholder="Occupation 3"/>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="basicInput">Date of Birth</label>
                        <input type="date" class="form-control" name="family_dob[]" id="family_dob" placeholder="Date of Birth 4"/>
                      </div>
                    </div>
                  </div>
                  
                  @for($i=1;$i<=4;$i++)
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="basicInput">&nbsp;</label>
                        <input type="text" class="form-control textonly" name="family_name[]" id="family_name" placeholder="Name {{$i+1}}"/>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="basicInput">&nbsp;</label>
                        <input type="text" class="form-control" name="family_relation[]" id="family_relation" placeholder="Relation {{$i+1}}"/>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="basicInput">&nbsp;</label>
                        <input type="text" class="form-control" name="family_occupation[]" id="family_occupation" placeholder="Occupation {{$i+1}}"/>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="basicInput">&nbsp;</label>
                        <input type="date" class="form-control" name="family_bob[]" id="family_bob" placeholder="Date of Birth {{$i+1}}"/>
                      </div>
                    </div>
                  </div>
                  @endfor
                  
                </div>
                
                <div class="tab-pane fade " id="professional" role="tabpanel" aria-labelledby="professional-tab">
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
    $(document).ready(function () {
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
    let saveDataURL = "{{url('/admin/add-user/')}}";
    let returnURL = "{{url('/admin/users')}}";
</script> 
<script src="{{ asset('public/admin/js/pages/users/add-page.js') }}"></script> 
@endsection 