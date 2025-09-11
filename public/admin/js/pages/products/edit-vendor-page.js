    $(document).ready(function(){
    var formSubmitted = false;
	$('#form_submit, #form_submit1').click(function(e){
		var flag = 0;
        var submitBTN = $(this).attr('id');
        if(!formSubmitted){
            formSubmitted = false;
            if($.trim($("#product_qty").val()) == ''){
                flag = 1;
                swal("Error!", 'Please Enter Product Quantity.', "error");
                return false;
            }

            if(flag == 0){

                $('#'+submitBTN+' .indicator-label').addClass('d-none');
                $('#'+submitBTN+' .indicator-progress').removeClass('d-none');

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
                        window.onbeforeunload = null;
                        formSubmitted = false;
                        $('#'+submitBTN+' .indicator-label').removeClass('d-none');
                        $('#'+submitBTN+' .indicator-progress').addClass('d-none');

                        if(obj['heading'] == "Success"){
                            swal("", obj['msg'], "success").then((value) => {								
								if(submitBTN == "form_submit1"){
									window.location.assign(editDataURL);
								}else{
									window.location.assign(returnURL);
								}
                            });
                        }else{
                            swal("Error!", obj['msg'], "error");
                            return false;
                        }
                    },error: function(ts) {
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
