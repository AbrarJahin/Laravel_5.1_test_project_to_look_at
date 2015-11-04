
$('.delete-resource').on('click',function(e){
	var link = $(this).attr('href');
	var token = $('#meta').attr('csrf-token');
	var confirmed = confirm("are you sure that you want to delete?");
	
	if(confirmed) {
		$.ajax({
			url: link,
			data: {_token: token},
			type: 'DELETE',
			success: function(result) {
				location.reload();
			}
		});
	}
	return false;
});
