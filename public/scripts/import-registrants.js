$(function(){
	$('#subscriberslist-create-form').on('submit', function(e){
		e.preventDefault();
		var lines = $('#subscribers-import').val().split("\n");
		var subscribers = [];

		lines.map(function(line){
			var vals = line.split(',');
			//we must have ['firrst', 'last', 'email'] in this array.
			if(vals.length != 3) { 
				alert("Invalid input");
				return false;
			}

			subscribers.push({
				first_name: vals[0],
				last_name: vals[1],
				email: vals[2].toLowerCase()
			});
		});

		var submitUrl = $(this).attr('action');
		var payload = {
			_token: $('input[name=_token]').val(),
			subscribers: subscribers
		};

		$('#subscriber-success').addClass('hidden');
		$('#subscriber-error').addClass('hidden');
		$.post(submitUrl, payload, function(result){
			$('#subscriber-success').removeClass('hidden');
			setTimeout(function(){
				location.reload();
			},2000);
		}).fail(function(error){
			$('#subscriber-error').removeClass('hidden');
			$('#subscriber-error').show();
		});

		return false;
	});
});


$('.registrant-delete').on('click',function(e){
	var link = $(this).attr('href');
	var token = $('#meta').attr('csrf-token');
	var confirmed = confirm("are you sure that you want to delete this subscriber?");
	
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
