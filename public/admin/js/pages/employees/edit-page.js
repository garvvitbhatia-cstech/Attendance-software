$(document).ready(function(){
    var formSubmitted = false;
	$('#form_submit').click(function(e){
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
			if($.trim($("#last_name").val()) == ''){
				flag = 1;
				$("#last_name").focus();
				swal("Error!", 'Please Enter Last Name.', "error");
				return false;
			}
			if($.trim($("#father_name").val()) == ''){
				flag = 1;
				$("#father_name").focus();
				swal("Error!", 'Please Enter Father Name.', "error");
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
			if($.trim($("#password").val()) == ''){
				flag = 1;
				$("#password").focus();
				swal("Error!", 'Please Enter Password.', "error");
				return false;
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

            if(flag == 0){
                $('#form_submit .indicator-label').addClass('d-none');
                $('#form_submit .indicator-progress').removeClass('d-none');
                var form = $('#pageForm')[0];
                var formData = new FormData(form);
                formSubmitted = true;
                $.ajax({
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: saveDataURL,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(msg){
                        var obj = JSON.parse(msg);
                        formSubmitted = false;
                        $('#form_submit .indicator-label').removeClass('d-none');
                        $('#form_submit .indicator-progress').addClass('d-none');
                        if(obj['heading'] == "Success"){
                            swal("", obj['msg'], "success").then((value) => {
                                window.location.assign(returnURL);
                            });
                        }else{
                            swal("Error!", obj['msg'], "error");
                            return false;
                        }
                    },error: function(ts){
                        formSubmitted = false;
                        $('#form_submit .indicator-label').removeClass('d-none');
                        $('#form_submit .indicator-progress').addClass('d-none');
                        swal("Error!", 'Some thing want to wrong, please try after sometime.', "error");
                        return false;
                    }
                });
            }
        }
	});
});