var baseURL = $('meta[name=base_url]').attr("content")+'/';
var lastClicked = 0;
var token = $('meta[name=csrf_token]').attr("content");

function ajax_voting(yes_no_value)
{
	var now = new Date();
	if(now - lastClicked > 10000)
	{
		lastClicked = now;
		console.log(yes_no_value);
		$.ajax(
		{
			headers: { 'X-CSRF-TOKEN': token},
			url: baseURL+"add_votes",
			success: function(result)
			{
				alert(result);
				console.log(token);
			},
			method: "POST",
			data:
			{
				_token:			token,
				yes_no_value:	yes_no_value,
				uuid : $('meta[name=webniar_ID_int]').attr("content")
			},
			statusCode:	{
							407: function()
							{
								$.ajaxSetup(
												{
													dataType: "jsonp"
												});
								// Now all AJAX requests use JSONP, retry.
								original();
							}
						},
		});
	}
}

$(document).ready(function()
{
	$( "#button_yes" ).click(function()
	{
		ajax_voting('yes');
	});

	$( "#button_no" ).click(function()
	{
		ajax_voting('no');
	});

	$( "#question_add_in_my" ).click(function()
	{
		var question = $("#asked_question_add_in_my").val();
		console.log(question);
		$.ajax(
			{
				headers: { 'X-CSRF-TOKEN': token},
				url: baseURL+"post_add_question",
				success: function(result)
				{
					console.log(result);
					//"<li>"+result.question+"</li>"
					$("#private_questions ul").	append(
															$('meta[name=qustion_before]').attr("content") 					+result.question+
															$('meta[name=qustion_after_datetime_before]').attr("content")	+result.datetime+
															$('meta[name=datetime_after_name_bfore]').attr("content") 		+result.name+
															$('meta[name=name_after_time_before]').attr("content") 			+result.ask_before+
															$('meta[name=time_after]').attr("content")
														);
					$("#asked_question_add_in_my").val('');
				},
				method: "POST",
				data:
				{
					_token		:	token,
					question	: 	question,
					public		: 	1,
                    subscriber_id:$('meta[name=subscriber_id]').attr("content"),
                    webinar_id	:	$('meta[name=webinar_id]').attr("content")
				},
			});
	});

	$( "#question_add_in_public" ).click(function()
	{
		var question = $("#asked_question_add_in_public").val();
		console.log(question);
		$.ajax(
			{
				headers: { 'X-CSRF-TOKEN': token},
				url: baseURL+"post_add_question",
				success: function(result)
				{
					console.log(result);
					//"<li>"+result.question+"</li>"
					$("#public_questions ul").	append(
															$('meta[name=qustion_before]').attr("content") 					+result.question+
															$('meta[name=qustion_after_datetime_before]').attr("content")	+result.datetime+
															$('meta[name=datetime_after_name_bfore]').attr("content") 		+result.name+
															$('meta[name=name_after_time_before]').attr("content") 			+result.ask_before+
															$('meta[name=time_after]').attr("content")
														);
					$("#asked_question_add_in_public").val('');
				},
				method: "POST",
				data:
				{
					_token		:	token,
					question	: 	question,
					public		: 	1,
					webinar_id	:	$('meta[name=webinar_id]').attr("content") 
				},
			});
	});

    function resetSharedUrl(){
        $.ajax(
            {
                headers: { 'X-CSRF-TOKEN': token},
                url: baseURL+"get_webinar_share",
                method: "POST",
                data:
                {
                    _token		:	token,
                    webinarId	:	$('meta[name=webinar_id]').attr("content")
                },
                success: function(data)
                {
                    $('#sharedUrl').val(data);
                }
            }
        );
    }

	$('body').on( 'click', '#subscriber_name_submit', function (){

		var firstName = $('#subscriber_first_name').val();
		var lastName = $('#subscriber_last_name').val();

		$.ajax(
				{
					headers: { 'X-CSRF-TOKEN': token},
					url: baseURL+"post_change_subscriber_name",
					method: "POST",
					data:
					{
						subscriber_id: $('meta[name=subscriber_id]').attr("content"),
						first_name: firstName,
						last_name: lastName
					},
					success: function(data)
					{
						console.log('Name updated');
					}
				}
		);

	});

    setInterval(resetSharedUrl, 5000);

});