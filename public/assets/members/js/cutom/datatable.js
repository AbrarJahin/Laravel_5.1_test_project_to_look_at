function merge_selectd_collumns()		//Do something for AJAX merge 
{
	var token_temp 	= $('meta[name=csrf_token]').attr("content");//$('#meta').attr('csrf_token');
	var baseURL		= $('meta[name=base_url]').attr("content")+'/';
	var tableControl= document.getElementById('employee-grid');
	var arrayOfValues = [];
	arrayOfValues	=	$('input:checkbox:checked', tableControl).map(function()
						{
							var temp_data = $(this).val();//closest('tr').find('td:last').html();
							if (!isNaN(temp_data))
								return temp_data;
						});
	if(arrayOfValues.length>1)
	{
		console.log(arrayOfValues);
		////////////AJAX call
		$.ajax(
		{
			headers: { 'X-CSRF-TOKEN': token_temp},
			url: baseURL+"add_votes",
			success: function(result)
			{
				alert(result);
				console.log(result);
				console.log(token_temp);
			},
			method: "POST",
			data:
			{
				_token:			token_temp,
				uuid : $('meta[name=webniar_ID]').attr("content")
			},
		});
		/////////AJAX call
	}
	else
		alert("Please select at least 2 columns for marging");
}

$(document).ready(function()
{
	var baseURL					= $('meta[name=base_url]').attr("content")+'/';//"http://localhost/gtwhero/public/";
	var url						= window.location.href;
	var userId					= (url.match(/\/users\/(\d+)\//) || [])[1];
	var subscribers_lists_Id	= (url.match(/\/subscribers-lists\/(\d+)\//) || [])[1];
	var token = $('#meta').attr('csrf-token');

	//////////////////////For Subscribers of ({Name}}) of /users/3/subscribers-lists
	var dataTable = $('#subscribers_list').DataTable(
	{
		"processing": true,
		"serverSide": true,
		"ajax":
		{
			url : baseURL+"ajax_subscribers_list", // json datasource
			type: "post",  // method  , by default get
			error: function()
			{  // error handling
				$(".subscribers_list-error").html("");
				$("#subscribers_list").append('<tbody class="subscribers_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
				$("#subscribers_list_processing").css("display","none");
			},
			"data": function ( d )				//Sending Custom Data for manupulating with elements out of the table
						{
							d.user_id_of_current_page	=	userId;
						}
		},
		"columns":	[				//Name should be same as PHP file JSON NAmes and ordering should be as in the HTML file
						{	"data": "name"					},
						{	"data": "count_openers"			},
						{	"data": "count_clickers"		},
						{	"data": "count_active"			},
						{	"data": "count_unsubsribers"	},
						{	"data": "count_bounced"			},
						{	"data": "count_total"			},
						{	"data": "last_activity"			},
						{	"data": null					},		//If it is not null then buttons would not be shown
						{	"data": null					}
					],
		//"pagingType": "full_numbers",	//Adding Last and First in Pagination
		stateSave: true,
		"columnDefs":	[								//For Action Buttons (Edit and Delete button) adding in the Action Column
							{
								"orderable": false,		//Turn off ordering
								"searchable": false,	//Turn off searching
								"targets": [8],			//Going to last column - 3 is the last column index because o is starting index
								"data": null,			//Not receiving any data
								"defaultContent": '<button type="button" class="details btn btn-info btn-sm"><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"> More..</span></button>'
							},
							{
								'targets': [9],
								'searchable':false,
								'orderable':false,
								'className': 'dt-body-center',
								'render': function (data, type, full, meta)
								{
									return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data['id']).html() + '">';
								}
							}
						],
		dom: 'l<"toolbar">Bfrtip',	//"Bfrtip" is for column visiblity - B F and R become visible
		initComplete:	function()	//Adding Custom button in Tools
						{
							$("div.toolbar").html('<button onclick="merge_selectd_collumns()" type="button" class="btn btn-info btn-sm" style="float:right;">Merge Selected Columns</button>');
						}
	});

	$('#subscribers_list tbody').on( 'click', 'button.details', function ()	//Handeling Edit Button Click
	{
		var data = dataTable.row( $(this).parents('tr') ).data();
		//alert(data['id']);	//id = index of ID sent from server
		window.location.replace(baseURL+'users/'+userId+'/subscribers-lists/'+data['id']+'/subscribers');
	});

	//Select All
	$('#select_all').click(function(e)
	{
		var table= $(e.target).closest('table');
		$('td input:checkbox',table).prop('checked',this.checked);
	});

	//Export
	$('#export_subscriber_list').click(function(e)
	{
		window.location.replace(baseURL+'post_export_subscriber_list');
	});

	$('#export_subscriber_list_members').click(function(e)
	{
		//alert("export_subscriber_list_members");
		window.location.replace(baseURL+'post_export_subscriber_list_members');
	});


	//////////////////////For Subscribers of ({Name}}) of /users/3/subscribers-lists table 2 -> Subscribers list by members
	var dataTable = $('#subscribers_list_by_members').DataTable(
	{
		"processing": true,
		"serverSide": true,
		"ajax":
		{
			url : baseURL+"ajax_subscribers_list_by_members", // json datasource
			type: "post",  // method  , by default get
			error: function()
			{  // error handling
				$(".subscribers_list_by_members-error").html("");
				$("#subscribers_list_by_members").append('<tbody class="subscribers_list_by_members-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
				$("#subscribers_list_processing").css("display","none");
			},
			"data": function ( d )				//Sending Custom Data for manupulating with elements out of the table
						{
							d.user_id_of_current_page	=	userId;
						}
		},
		"columns":	[				//Name should be same as PHP file JSON NAmes and ordering should be as in the HTML file
						{	"data": "name"					},
						{	"data": "count_openers"			},
						{	"data": "count_clickers"		},
						{	"data": "count_active"			},
						{	"data": "count_unsubsribers"	},
						{	"data": "count_bounced"			},
						{	"data": "count_total"			},
						{	"data": "last_activity"			},
						{	"data": null					}
					],
		//"pagingType": "full_numbers",	//Adding Last and First in Pagination
		stateSave: true,
		"columnDefs":	[								//For Action Buttons (Edit and Delete button) adding in the Action Column
							{
								"orderable": false,		//Turn off ordering
								"searchable": false,	//Turn off searching
								"targets": [8],			//Going to last column - 3 is the last column index because o is starting index
								"data": null,			//Not receiving any data
								"defaultContent": '<button type="button" class="details btn btn-info btn-sm"><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"> More..</span></button>'
							}
						]
	});

	$('#subscribers_list_by_members tbody').on( 'click', 'button.details', function ()	//Handeling Edit Button Click
	{
		var data = dataTable.row( $(this).parents('tr') ).data();
		//alert(data['id']);	//id = index of ID sent from server
		window.location.replace(baseURL+'users/'+userId+'/subscribers-lists/'+data['id']+'/subscribers');
	});

	//////////////////////For Subscribers of ({Name}}) of /users/3/subscribers-lists/1/subscribers
	var subscribers_names_dataTable = $('#subscribers_names').DataTable(
	{
		"processing": true,
		"serverSide": true,
		"ajax":
		{
			url :baseURL+"ajax_subscribers_names", // json datasource
			type: "post",  // method  , by default get
			error: function()
			{  // error handling
				$(".subscribers_names-error").html("");
				$("#subscribers_names").append('<tbody class="subscribers_names-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
				$("#subscribers_list_processing").css("display","none");
			},
			"data": function ( d )				//Sending Custom Data for manupulating with elements out of the table
						{
							d.user_id_of_current_page	=	userId;
							d.subscribers_lists_Id		=	subscribers_lists_Id;
						}
		},
		"columns":	[				//Name should be same as PHP file JSON NAmes and ordering should be as in the HTML file
						{	"data": "first_name"	},
						{	"data": "last_name"		},
						{	"data": "email"			},
						{	"data": "status"		},
                                                {	"data": "uuid"		},
						{	"data": "updated_at"	},
						{	"data": null			}		//If it is not null then buttons would not be shown
					],
		//"pagingType": "full_numbers",	//Adding Last and First in Pagination
		stateSave: true,
		"columnDefs":	[								//For Action Buttons (Edit and Delete button) adding in the Action Column
							{
								"orderable": false,		//Turn off ordering
								"searchable": false,	//Turn off searching
								"targets": [6],			//Going to last column - 3 is the last column index because o is starting index
								"data": null,			//Not receiving any data
								"defaultContent": '<div style="min-width:70px" class="btn-group" role="group"><button type="button" class="edit btn btn-warning btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button><button type="button" class="delete btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></div>'
							}
						],
	});

	$('#subscribers_names tbody').on( 'click', 'button.edit', function ()	//Handeling Edit Button Click
	{
		var data = subscribers_names_dataTable.row( $(this).parents('tr') ).data();
		window.location.replace(window.location.href+'/'+data['id']+'/edit');
	} );

	$('#subscribers_names tbody').on( 'click', 'button.delete', function ()	//Handeling Delete Button Click
	{
		var data = subscribers_names_dataTable.row( $(this).parents('tr') ).data();
		//alert(data['id']);	//id = index of ID sent from server
		var url_for_delete = baseURL+'delete_subscribers';
		//http://localhost/gtwhero/public/users/3/subscribers-lists/3/subscribers/1
		console.log(url_for_delete);
		var confirmed = confirm("Are you sure that you want to delete this subscriber?");
		console.log(token);
		if(confirmed)
		{
			$.ajax(
			{
				headers: { 'X-CSRF-TOKEN': token},
				url: url_for_delete,
				success: function(result)
				{
					location.reload();
				},
				method: "delete",
				data:
				{
					_token:			token,
					list_id:		subscribers_lists_Id,
					subscriber_id:	data['id'],
				}
			});
		}
	} );


	//////////////////////For pnelist of /users/{id}}/panelists
	var pane_list = $('#pane_list').DataTable(
	{
		"processing": true,
		"serverSide": true,
		"ajax":
		{
			url :baseURL+"ajax_pane_list", // json datasource
			type: "post",  // method  , by default get
			error: function()
			{  // error handling
				$(".pane_list-error").html("");
				$("#pane_list").append('<tbody class="pane_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
				$("#subscribers_list_processing").css("display","none");
			},
			"data": function ( d )				//Sending Custom Data for manupulating with elements out of the table
						{
							d.user_id_of_current_page	=	userId;
						}
		},
		"columns":	[				//Name should be same as PHP file JSON NAmes and ordering should be as in the HTML file
						{	"data": "name"		},
						{	"data": "email"		},
						{	"data": "status"	},
						{	"data": null		}		//If it is not null then buttons would not be shown
					],
		//"pagingType": "full_numbers",	//Adding Last and First in Pagination
		stateSave: true,
		"columnDefs":	[								//For Action Buttons (Edit and Delete button) adding in the Action Column
							{
								"orderable": false,		//Turn off ordering
								"searchable": false,	//Turn off searching
								"targets": [3],			//Going to last column - 3 is the last column index because o is starting index
								"data": null,			//Not receiving any data
								"defaultContent": '<div style="min-width:70px" class="btn-group" role="group"><button type="button" class="edit btn btn-warning btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button><button type="button" class="delete btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></div>'
							}
						],
	});

	$('#pane_list tbody').on( 'click', 'button.edit', function ()	//Handeling Edit Button Click
	{
		var data = pane_list.row( $(this).parents('tr') ).data();
		window.location.replace(window.location.href+'/'+data['id']+'/edit');
	} );

	$('#pane_list tbody').on( 'click', 'button.delete', function ()	//Handeling Delete Button Click
	{
		var data = pane_list.row( $(this).parents('tr') ).data();
		//alert(data['id']);	//id = index of ID sent from server
		var url_for_delete = baseURL+'delete_panelists';
		//http://localhost/gtwhero/public/users/3/subscribers-lists/3/subscribers/1
		console.log(url_for_delete);
		var confirmed = confirm("are you sure that you want to delete this subscriber?");
	
		if(confirmed)
		{
			$.ajax({
				url: url_for_delete,
				data: 	{
							_token:			token,
							user_id:		userId,
							panelist_id:	data['id'],
						},
				type: 'delete',
				success: function(result)
				{
					console.log(result);
					location.reload();
				}
			});
		}
	});

	//////////////////////For pnelist of /users/3/webinars - Upcoming
	var upcoming_webinars_list = $('#upcoming_webinars_list').DataTable(
	{
		"processing": true,
		"serverSide": true,
		"ajax":
		{
			url :baseURL+"ajax_upcoming_webinars_list", // json datasource
			type: "post",  // method  , by default get
			error: function()
			{  // error handling
				$(".upcoming_webinars_list-error").html("");
				$("#upcoming_webinars_list").append('<tbody class="upcoming_webinars_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
				$("#subscribers_list_processing").css("display","none");
			},
			"data": function ( d )				//Sending Custom Data for manupulating with elements out of the table
						{
							d.user_id_of_current_page	=	userId;
						}
		},
		"columns":	[				//Name should be same as PHP file JSON NAmes and ordering should be as in the HTML file
						{	"data": null,			//Not receiving any data
							"orderable": false,		//Turn off ordering
							"targets": [0],			//Going to last column - 3 is the last column index because o is starting index
							"searchable": false,	//Turn off searching
							"defaultContent": '<button type="button" class="details preview btn btn-info btn-sm"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button>'
						},						{	"data": "title"			},
						{	"data": "starts"		},
						{	"data": "created_at"	},
						{	"data": null			}		//If it is not null then buttons would not be shown
					],
		//"pagingType": "full_numbers",	//Adding Last and First in Pagination
		stateSave: true,
		"columnDefs":	[								//For Action Buttons (Edit and Delete button) adding in the Action Column
							{
								"orderable": false,		//Turn off ordering
								"searchable": false,	//Turn off searching
								"targets": [4],			//Going to last column - 3 is the last column index because o is starting index
								"data": null,			//Not receiving any data
								"defaultContent": '<button type="button" class="details edit btn btn-info btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"> Manage</span></button>'
							}
						],
	});

	$('#upcoming_webinars_list tbody').on( 'click', 'button.edit', function ()	//Handeling Edit Button Click
	{
		var data = upcoming_webinars_list.row( $(this).parents('tr') ).data();
		window.location.replace(window.location.href+'/'+data['id']+'/edit');
	} );

	$('#upcoming_webinars_list tbody').on( 'click', 'button.preview', function ()	//Handeling Edit Button Click
	{
		var data = upcoming_webinars_list.row( $(this).parents('tr') ).data();
		window.open(baseURL+'webinar/'+data['id']+'/preview', '_blank');
	} );

	$('#upcoming_webinars_list tbody').on( 'click', 'button.delete', function ()	//Handeling Delete Button Click
	{
		var data = upcoming_webinars_list.row( $(this).parents('tr') ).data();
		//alert(data['id']);	//id = index of ID sent from server
		var url_for_delete = baseURL+'delete_webinars';
		//http://localhost/gtwhero/public/users/3/subscribers-lists/3/subscribers/1
		console.log(url_for_delete);
		var confirmed = confirm("are you sure that you want to delete this subscriber?");
	
		if(confirmed)
		{
			$.ajax({
				url: url_for_delete,
				data: 	{
							_token:			token,
							user_id:		userId,
							uuid:			data['id'],
						},
				type: 'delete',
				success: function(result)
				{
					console.log(result);
					location.reload();
				}
			});
		}
	});

	//////////////////////For pnelist of /users/3/webinars - Past
	var past_webinars_list = $('#past_webinars_list').DataTable(
	{
		"processing": true,
		"serverSide": true,
		"ajax":
		{
			url :baseURL+"ajax_past_webinars_list", // json datasource
			type: "post",  // method  , by default get
			error: function()
			{  // error handling
				$(".past_webinars_list-error").html("");
				$("#past_webinars_list").append('<tbody class="past_webinars_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
				$("#subscribers_list_processing").css("display","none");
			},
			"data": function ( d )				//Sending Custom Data for manupulating with elements out of the table
						{
							d.user_id_of_current_page	=	userId;
						}
		},
		"columns":	[				//Name should be same as PHP file JSON NAmes and ordering should be as in the HTML file
						{	"data": null,			//Not receiving any data
							"orderable": false,		//Turn off ordering
							"targets": [0],			//Going to last column - 3 is the last column index because o is starting index
							"searchable": false,	//Turn off searching
							"defaultContent": '<button type="button" class="details preview btn btn-info btn-sm"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button>'
						},
						{	"data": "title"			},
						{	"data": "starts"		},
						{	"data": "created_at"	},
						{	"data": null			}		//If it is not null then buttons would not be shown
					],
		//"pagingType": "full_numbers",	//Adding Last and First in Pagination
		stateSave: true,
		"columnDefs":	[								//For Action Buttons (Edit and Delete button) adding in the Action Column
							{
								"orderable": false,		//Turn off ordering
								"searchable": false,	//Turn off searching
								"targets": [4],			//Going to last column - 3 is the last column index because o is starting index
								"data": null,			//Not receiving any data
								"defaultContent": '<button type="button" class="details edit btn btn-info btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"> Manage</span></button>'
							}
						],
	});

	$('#past_webinars_list tbody').on( 'click', 'button.edit', function ()	//Handeling Edit Button Click
	{
		var data = past_webinars_list.row( $(this).parents('tr') ).data();
		window.location.replace(window.location.href+'/'+data['id']+'/edit');
	} );


	$('#past_webinars_list tbody').on( 'click', 'button.preview', function ()	//Handeling Edit Button Click
	{
		var data = past_webinars_list.row( $(this).parents('tr') ).data();
		window.open(baseURL+'webinar/'+data['id']+'/preview', '_blank');
	} );

	$('#past_webinars_list tbody').on( 'click', 'button.delete', function ()	//Handeling Delete Button Click
	{
		var data = past_webinars_list.row( $(this).parents('tr') ).data();
		//alert(data['id']);	//id = index of ID sent from server
		var url_for_delete = baseURL+'delete_webinars';
		//http://localhost/gtwhero/public/users/3/subscribers-lists/3/subscribers/1
		console.log(url_for_delete);
		var confirmed = confirm("are you sure that you want to delete this subscriber?");
	
		if(confirmed)
		{
			$.ajax({
				url: url_for_delete,
				data: 	{
							_token:			token,
							user_id:		userId,
							uuid:			data['id'],
						},
				type: 'delete',
				success: function(result)
				{
					console.log(result);
					location.reload();
				}
			});
		}
	});
});