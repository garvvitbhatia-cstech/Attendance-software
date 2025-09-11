<link href="{{ asset('public/css/sweet-alert.css') }}" rel="stylesheet" />
<script src="{{ asset('public/js/sweet-alert.min.js') }}"></script>

<script>
function changeStatus(table,rowID,status){
	$.ajax({
		type: 'POST',
		url: "{{ url('/admin/change-status') }}",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: {table:table,rowID:rowID,status:status},
		success: function(response){
			if(response == 'Success'){
				filterData('simple');
			}else if(response == 'SessionExpire'){
				alert('Unauthorized User.'); return false;
			}else if(response == 'InvalidData'){
				swal({
					title: "Oops!",
					html: 'Invalid Data.',
					type: "error",
					timer: 3000
				});
			}else{
				swal({
					title: "Oops!",
					text: response,
					type: "warning",
					timer: 3000
				});
			}
		}
	});
}

function UpdateStatusAll(status){
    var productIDs = $(".mod_products:checked").map(function(){
        return $(this).val();
    }).get();
	swal({
		title: "Are you sure?",
		text: "You want to update the status for all selected products!",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	})
	.then((willDelete) => {
	if (willDelete){
		$.ajax({
			type: 'POST',
			url: "{{ url('/admin/product/change-status') }}",
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {productIDs:productIDs,status:status},
			success: function(response){
				if(response == 'Success'){
					filterData('simple');
				}else if(response == 'SessionExpire'){
					alert('Unauthorized User.'); return false;
				}else if(response == 'InvalidData'){
					swal({
						title: "Oops!",
						html: 'Invalid Data.',
						type: "error",
						timer: 3000
					});
				}else{
					swal({
						title: "Oops!",
						text: response,
						type: "warning",
						timer: 3000
					});
				}
			}
		});
		}else{
			swal("Your record is safe!");
		}
	});
}

function deleteData(table,rowID){
	if(table != "" && rowID != ""){
        swal({
			title: "Are you sure?",
			text: "Once deleted, you will not be able to recover this record!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                url: "{{ url('/admin/delete-record') }}",
                data: {table:table,rowID:rowID},
                success: function(msg){
                    if(msg == "Success"){
                        swal({
                        title: 'Success',
                        text: 'Record has been deleted successfully.',
                        type: 'success',
                        confirmButtonText: 'Ok',
                        confirmButtonColor: "#009EF7"});
                        if(table =='product_images'){
                            $('#item_'+rowID).remove();
                        }else if(table =='product_ingredients'){
                            $('#rowID'+rowID).remove();
                            $('#indID'+rowID).remove();
                        }else if(table =='product_quantity_discounts'){
                            $('#dr_rowID'+rowID).remove();
                            $('#dr_disc_id'+rowID).remove();
                            $('#user_rowID'+rowID).remove();
                            $('#user_disc_id'+rowID).remove();
                        }else{
                            filterData('simple');
                        }
                    }else{
                        swal({
                            title: "Oops!",
                            text: msg,
                            type: "warning",
                            timer: 3000
                        });
                    }
                }
            });
        }else{
            swal("Your record is safe!");
        }
        });
	}else{
		return false;
	}
}

function DeleteAll(){
	var productIDs = $(".mod_products:checked").map(function(){
		return $(this).val();
	}).get();
	swal({
		title: "Are you sure?",
		text: "Once deleted, you will not be able to recover all selected records!",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	})
	.then((willDelete) => {
	if (willDelete){
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			type: 'POST',
			url: "{{ url('/admin/product/delete-record') }}",
			data: {productIDs:productIDs},
			success: function(msg){
				if(msg == "Success"){
					swal({
					title: 'Success',
					text: 'Record has been deleted successfully.',
					type: 'success',
					confirmButtonText: 'Ok',
					confirmButtonColor: "#009EF7"});
					filterData('simple');
				}else{
					swal({
						title: "Oops!",
						text: msg,
						type: "warning",
						timer: 3000
					});
				}
			}
		});
		}else{
			swal("Your record is safe!");
		}
	});
}

$(document).ready(function(){
    $(window).keydown(function(event){
    if((event.which== 13) && ($(event.target)[0]!=$("textarea")[0])){
      //event.preventDefault();
     // return false;
    }
  });
	$("#searchForm input").on('keyup', function (e){
		if (e.keyCode == 13){
			filterData('search');
		}
	});
	$('#replaceHtml').on('click', '#pagination a', function(){
		var url = $(this).attr('href');
		$('#replaceHtml').load(url);
		return false;
	});

});

function resetFilterForm(){
    $('#searchForm')[0].reset();
    filterData('simple');
}

function setMask(id){
    $("#"+id).mask("9999999999");
}
</script>