    $(document).ready(function(){
    var formSubmitted = false;
	$('#form_submit, #form_submit1').click(function(e){
		var flag = 0;
        var submitBTN = $(this).attr('id');
        if(!formSubmitted){
            formSubmitted = false;
			var error_info = '';
			var error_price = '';
			var error_qtydis = '';
			var error_permission = '';
			var error_size = '';
			var error_image = '';
			var error_ingrediants = '';
			var error_description = '';
			var error_seo = '';
			
			$('#info_error_div').html(null);
			$('#price_error_div').html(null);
			$('#qtydis_error_div').html(null);
			$('#permission_error_div').html(null);
			$('#sizes_error_div').html(null);
			$('#image_error_div').html(null);
			$('#ingrediants_error_div').html(null);
			$('#description_error_div').html(null);
			$('#seo_error_div').html(null);
			
            if($.trim($("#product_name").val()) == ''){
                flag = 1;
                //swal("Error!", 'Please Enter Product Name.', "error");
                //return false;
				error_info += 'Please Enter Product Name.<br />';
				//$('#product_nameError').html('Please Enter Product Name.');
            }
            if($.trim($("#category_id").val()) == ''){
                flag = 1;
                //swal("Error!", 'Please Enter Category Title.', "error");
                //return false;
				error_info += 'Please Enter Category Title.<br />';
				//$('#category_idError').html('Please Enter Category Title.');
            }
            if($.trim($("#sub_category_id").val()) == ''){
                flag = 1;
                //swal("Error!", 'Please Enter Sub-Category Title.', "error");
                //return false;
				error_info += 'Please Enter Sub-Category Title.<br />';
				//$('#sub_category_idError').html('Please Enter Sub-Category Title.');
            }
            if($.trim($("#brand_id").val()) == ''){
                flag = 1;
               // swal("Error!", 'Please Enter Brand Title.', "error");
                //return false;
				error_info += 'Please Enter Brand Title.<br />';
				//$('#brand_idError').html('Please Enter Brand Title.');
            }
			if($.trim($("#product_type").val()) == ''){
                flag = 1;
                //swal("Error!", 'Please Enter Product Type.', "error");
               // return false;
			   error_info += 'Please Enter Product Type.<br />';
			   //$('#product_typeError').html('Please Enter Product Type.');
            }
			if($.trim($("#hsn_code").val()) == ''){
                flag = 1;
                //swal("Error!", 'Please Enter HSN Code.', "error");
                //return false;
				error_info += 'Please Enter HSN Code.<br />';
				//$('#hsn_codeError').html('Please Enter HSN Code.');
            }
			if($.trim($("#product_qty").val()) == ''){
                flag = 1;
               // swal("Error!", 'Please Enter Product Quantity.', "error");
                //return false;
				error_info += 'Please Enter Product Quantity.<br />';
				//$('#product_qtyError').html('Please Enter Product Quantity.');
            }			
            if($.trim($("#ailment_id").val()) == ''){
                flag = 1;
                //swal("Error!", 'Please Enter Ailment Title.', "error");
                //return false;
				error_info += 'Please Enter Ailment Title.<br />';
				//$('#ailment_idError').html('Please Enter Ailment Title.');
            }
			if($.trim($("#pack_size").val()) == ''){
                flag = 1;
               // swal("Error!", 'Please Enter Pack Size.', "error");
                //return false;
				error_info += 'Please Enter Pack Size.<br />';
				//$('#pack_sizeError').html('Please Enter Pack Size.');
            }
			
			if($.trim($("#mrp").val()) == ''){
                flag = 1;
                //swal("Error!", 'Please Enter MRP.', "error");
                //return false;
				error_price += 'Please Enter MRP.<br />';
				//$('#mrpError').html('Please Enter MRP.');
            }
			if($.trim($("#list_price").val()) == ''){
                flag = 1;
               // swal("Error!", 'Please Enter List Price.', "error");
                //return false;
				error_price += 'Please Enter List Price.<br />';
				//$('#list_priceError').html('Please Enter List Price.');
            }
			
			if($.trim($("#product_weight").val()) == ''){
                flag = 1;
               // swal("Error!", 'Please Enter Product Weight.', "error");
                //return false;
				error_size += 'Please Enter Product Weight.<br />';
				//$('#product_weightError').html('Please Enter Product Weight.');
            }
			if($.trim($("#product_width").val()) == ''){
                flag = 1;
               // swal("Error!", 'Please Enter Product Width.', "error");
               // return false;
			   error_size += 'Please Enter Product Width.<br />';
			  // $('#product_widthError').html('Please Enter Product Width.');
            }
			if($.trim($("#product_height").val()) == ''){
                flag = 1;
                //swal("Error!", 'Please Enter Product Height.', "error");
                //return false;
				error_size += 'Please Enter Product Height.<br />';
				//$('#product_heightError').html('Please Enter Product Height.');
            }
			if($.trim($("#product_length").val()) == ''){
                flag = 1;
               // swal("Error!", 'Please Enter Product Length.', "error");
                //return false;
				error_size += 'Please Enter Product Length.<br />';
				//$('#product_lengthError').html('Please Enter Product Length.');
            }	
					
			if($.trim($(".images_field").length) == 0){
                flag = 1;
               // swal("Error!", 'Please Select Atleast One Image.', "error");
                //return false;
				error_image += 'Please Select Atleast One Image.<br />';
				//$('#imageError').html('Please Select Atleast One Image.');
            }
			//if($('.ingredient_name').length == 1){
				if($.trim($(".ingredient_name").val()) == ''){
					flag = 1;
					//swal("Error!", 'Please Enter Short Description.', "error");
					//return false;
					error_ingrediants += 'Please Enter Ingredient Name.<br />';
					//$('#short_descriptionError').html('Please Enter Short Description.');
				}	
			//}
			
			//if($('.description').length == 1){
				if($.trim($(".description").val()) == ''){
					flag = 1;
					//swal("Error!", 'Please Enter Short Description.', "error");
					//return false;
					error_ingrediants += 'Please Enter Ingredient Description.<br />';
					//$('#short_descriptionError').html('Please Enter Short Description.');
				}	
			//}
			
			if($.trim($("#short_description").val()) == ''){
                flag = 1;
                //swal("Error!", 'Please Enter Short Description.', "error");
                //return false;
				error_description += 'Please Enter Short Description.<br />';
				//$('#short_descriptionError').html('Please Enter Short Description.');
            }
			if($.trim($("#long_description").val()) == ''){
                flag = 1;
               // swal("Error!", 'Please Enter Long Description.', "error");
                //return false;
				error_description += 'Please Enter Long Description.<br />';
				//$('#long_descriptionError').html('Please Enter Long Description.');
            }
			
			if($.trim($("#seo_title").val()) == ''){
                flag = 1;
               // swal("Error!", 'Please Enter SEO Title.', "error");
                //return false;
				error_seo += 'Please Enter SEO Title.<br />';
				//$('#seo_titleError').html('Please Enter SEO Title.');
            }
			if($.trim($("#seo_keywords").val()) == ''){
                flag = 1;
                //swal("Error!", 'Please Enter SEO Keywords.', "error");
                //return false;
				error_seo += 'Please Enter SEO Keywords.<br />';
				//$('#seo_keywordsError').html('Please Enter SEO Keywords.');
            }
			if($.trim($("#seo_description").val()) == ''){
                flag = 1;
               // swal("Error!", 'Please Enter SEO Description.', "error");
                //return false;
				error_seo += 'Please Enter SEO Description.<br />';
				//$('#seo_descriptionError').html('Please Enter SEO Description.');
            }
									
			if(error_info != ''){
				$('#info_error_div').html('<br><h6>Info Error</h6>');
				$('#info_error_div').append(error_info);		
			}			
			if(error_price != ''){
				$('#price_error_div').html('<br><h6>Prices Error</h6>');
				$('#price_error_div').append(error_price);		
			}			
			if(error_qtydis != ''){
				$('#qtydis_error_div').html('<br><h6>Quantity Discounts Error</h6>');
				$('#qtydis_error_div').append(error_qtydis);		
			}			
			if(error_permission != ''){
				$('#permission_error_div').html('<br><h6>Permissions Error</h6>');
				$('#permission_error_div').append(error_permission);		
			}
			if(error_size != ''){
				$('#sizes_error_div').html('<br><h6>Sizes Error</h6>');
				$('#sizes_error_div').append(error_size);		
			}
			if(error_image != ''){
				$('#image_error_div').html('<br><h6>Image Error</h6>');
				$('#image_error_div').append(error_image);		
			}
			if(error_ingrediants != ''){
				$('#ingrediants_error_div').html('<br><h6>Ingredients Error</h6>');
				$('#ingrediants_error_div').append(error_ingrediants);		
			}
			if(error_description != ''){
				$('#description_error_div').html('<br><h6>Description Error</h6>');
				$('#description_error_div').append(error_description);		
			}
			if(error_seo != ''){
				$('#seo_error_div').html('<br><h6>SEO Error</h6>');
				$('#seo_error_div').append(error_seo);		
			}	
			
			$('#error_refresh_div').html('');
			if(error_info != '' || error_price != '' || error_qtydis != '' || error_permission != '' || error_size != '' || error_image != '' || error_ingrediants != '' || error_description != '' || error_seo != ''){
				$('#error_refresh_div').html('<button type="button" id="refresh_btn" class="btn btn-sm btn-dark btn-active-light-primary me-5">Refresh</button>');
			}
            if(flag == 0){
				//$('#error_div').html(null);
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
									window.location.assign(editDataURL+'/'+obj['recordID']);
								}else{
									window.location.assign(returnURL);
								}
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

$(document).on('click','#refresh_btn',function(){
    $("#formSubmit").trigger("click");
});