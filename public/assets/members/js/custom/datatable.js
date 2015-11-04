$(document).ready(function()
{
	//For URL -> /subscribers-lists///////////////////////////////////////////////////////
	var baseURL					= $('meta[name=base_url]').attr("content");
	var url						= window.location.href;
	var userId					= (url.match(/\/users\/(\d+)\//) || [])[1];
	var subscribers_lists_Id	= (url.match(/\/subscribers-lists\/(\d+)\//) || [])[1];

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
					],
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

	$('#subscribers_list tbody').on( 'click', 'button.details', function ()	//Handeling Edit Button Click
	{
		var data = dataTable.row( $(this).parents('tr') ).data();
		//alert(data['id']);	//id = index of ID sent from server
		window.location.replace(baseURL+'/users/'+userId+'/subscribers-lists/'+data['id']+'/subscribers');
	});


	//For URL -> /panelists///////////////////////////////////////////////////////
	var dataTable = $('#pane_list').DataTable(
	{
		"processing": true,
		"serverSide": true,
		"ajax":
		{
			url :baseURL+"ajax_pane_list",//"ajax_pane_list", // json datasource
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
						{	"data": "id"		},
						{	"data": "name"		},
						{	"data": "email"		},
						{	"data": "status"	},
						{	"data": null		}		//If it is not null then buttons would not be shown
					],
		stateSave: true,
		"columnDefs":	[								//For Action Buttons (Edit and Delete button) adding in the Action Column
							{
								"orderable": false,		//Turn off ordering
								"searchable": false,	//Turn off searching
								"targets": [4],			//Going to last column - 4 is the last column index because o is starting index
								"data": null,			//Not receiving any data
								"defaultContent": '<div style="min-width:70px" class="btn-group" role="group"><button type="button" class="edit btn btn-warning btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button><button type="button" class="delete-resource delete btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></div>'
							}
						],
	});

	$('#pane_list tbody').on( 'click', 'button.edit', function ()	//Handeling Edit Button Click
	{
		var data = dataTable.row( $(this).parents('tr') ).data();
		window.location.replace(window.location.href+'/'+data['id']+'/edit');
	} );

	$('#pane_list tbody').on( 'click', 'button.delete', function ()	//Handeling Delete Button Click
	{
		var data = dataTable.row( $(this).parents('tr') ).data();
		if (confirm("Are you sure to delete?") == true)
		{	//Do something AJAX for deletation
			window.location.replace(window.location.href+'/'+data['id']);
		}
	} );
});