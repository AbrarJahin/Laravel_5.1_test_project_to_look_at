var baseURL = $('meta[name=base_url]').attr("content")+'/';
var token = $('meta[name=csrf_token]').attr("content");


setInterval(function()
{
    $.ajax(
    {
    	headers: { 'X-CSRF-TOKEN': token},
    	url: baseURL+"post_update_user_status",
    	success: function(result)
    	{
    		//alert(result);
    		console.log(token);
    	},
    	method: "POST",
    	data:
    	{
    		_token:			token,
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
}, 5000);