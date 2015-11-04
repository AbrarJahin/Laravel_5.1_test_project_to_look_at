<?php
// Add Default Route to Login Page
get('/', 'Auth\GTWAuthController@getLogin');

Route::controllers([
	'auth' => 'Auth\GTWAuthController',
	'admin' => 'AdminAreaController',
	'members' => 'MembersController'
]);

Route::get('users/{user_id}/webinars/{webinar_id}/clone', [
    'uses' => 'Resources\WebinarsController@getClone',
    'as' => 'users.webinars.clone'
]);

Route::post('users/{user_id}/webinars/{webinar_id}/clone', [
    'uses' => 'Resources\WebinarsController@postClone',
    'as' => 'users.webinars.clone.post'
]);

Route::post('users/{user_id}/webinars/{webinar_id}/email_notifications', [
    'uses' => 'Resources\WebinarsController@postEmailNotification',
    'as' => 'users.webinars.email_notifications.post'
]);

resource('users', 'Resources\UsersController');
resource('users.subscribers-lists', 'Resources\SubscribersListController');
resource('users.subscribers-lists.subscribers', 'Resources\SubscribersController');
resource('users.webinars', 'Resources\WebinarsController');
resource('users.panelists', 'Resources\PanelistsController');
resource('webinars.emails', 'Resources\EmailsController');
resource('qas', 'Resources\QAController');
Route::post('smtp/validate-smtp', [
    'as' => 'smtp.validate',
    'uses' => 'Resources\SmtpController@validateSmtp'
]);
resource('users.smtp', 'Resources\SmtpController');
resource('users.notification-templates', 'Resources\NotificationTemplatesController');

Route::get('users/{userId}/notification-templates/{templateId}/restore-defaults', [
    'uses' => 'Resources\NotificationTemplatesController@restoreDefaults',
    'as' => 'users.notification-templates.restore-defaults'
]);

Route::group(['prefix' => 'streaming-servers', 'namespace' => 'Resources'], function(){
    Route::get('', [
        'uses' => 'StreamingServersController@index',
        'as' => 'streaming-servers'
    ]);

    Route::get('create', [
        'uses' => 'StreamingServersController@create',
        'as' => 'streaming-servers.create'
    ]);

    Route::get('update/{id}', [
        'uses' => 'StreamingServersController@update',
        'as' => 'streaming-servers.update'
    ]);

    Route::post('create', [
        'uses' => 'StreamingServersController@postCreate',
        'as' => 'streaming-servers.create.post'
    ]);

    Route::post('update/{id}', [
        'uses' => 'StreamingServersController@postUpdate',
        'as' => 'streaming-servers.update.post'
    ]);

    Route::get('delete/{id}', [
        'uses' => 'StreamingServersController@delete',
        'as' => 'streaming-servers.delete'
    ]);

});

Route::group(array('prefix' => '/'), function() {

    Route::get('/webinar/{webinar_id}/panelist', array(
        'middleware' => 'user.panelist',
        'as' => 'site.panelist.webinar',
        'uses' => 'WebinarController@webinar')
    );
    
    Route::get('/webinar/{webinar_id}/signup', array(
        'as' => 'site.webinar.lp',
        'uses' => 'WebinarController@landingPage'
    ));

    Route::get('/webinar/{webinar_id}/{subscriber}', array(
        'as' => 'site.webinar',
        'uses' => 'WebinarController@index')
    );

    Route::get('/test-rtmp-video', function() {
        return view('layouts.webinar.test_rtmp_video');
    });
    
    Route::post('webinar/add-lead', array(
        'as' => 'site.webinar.add_lead',
        'uses' => 'WebinarController@addLead'
    ));

});

get('/webinar-layout',function(){
	return view('layouts.webinar.webinar-layout');
});

get('/panelist-webinar-layout',function(){
	return view('layouts.webinar.panelist-webinar-layout', ['is_panelist' => true]);
});

////////////////////////////////////////////////////Testing
Route::get('test','MembersController@getTest');
Route::post('add_question','MembersController@add_question');
///////////////////////////////////////////////////////////

Route::post('ajax_subscribers_list', [
    'as' => 'ajax.subscribers_list',
    'uses' => 'DatatableAJAXController@ajax_subscribers_list'
]);

Route::post('ajax_subscribers_list_by_members', [
    'as' => 'ajax.subscribers_list_by_members',
    'uses' => 'DatatableAJAXController@ajax_subscribers_list_by_members'
]);

Route::post('ajax_subscribers_names', [
    'as' => 'ajax.subscribers_names',
    'uses' => 'DatatableAJAXController@subscribers_names'
]);

Route::post('ajax_pane_list', [
    'as' => 'ajax.pane_list',
    'uses' => 'DatatableAJAXController@ajax_pane_list'
]);

Route::post('ajax_upcoming_webinars_list', [
    'as' => 'ajax.upcoming_webinars_list',
    'uses' => 'DatatableAJAXController@ajax_upcoming_webinars_list'
]);

Route::post('ajax_past_webinars_list', [
    'as' => 'ajax.subscribers_list',
    'uses' => 'DatatableAJAXController@ajax_past_webinars_list'
]);

Route::delete('delete_subscribers', [
    'as' => 'ajax.delete_subscribers',
    'uses' => 'DatatableAJAXController@delete_subscribers'
]);

Route::post('delete_panelists', [
    'as' => 'ajax.delete_panelists',
    'uses' => 'DatatableAJAXController@delete_panelists'
]);

Route::post('delete_webinars', [
    'as' => 'ajax.delete_webinars',
    'uses' => 'DatatableAJAXController@delete_webinars'
]);

Route::post('add_votes', [
    'as' => 'ajax.add_votes',
    'uses' => 'WebinarController@add_votes'
]);

Route::post('reset_votes', [
    'as' => 'ajax.reset_votes',
    'uses' => 'WebinarController@reset_votes'
]);

Route::post('post_chart_data', [
    'as' => 'ajax.post_chart_data',
    'uses' => 'AJAXController@post_chart_data'
]);

Route::post('post_chart_data_total', [
    'as' => 'ajax.post_chart_data_total',
    'uses' => 'AJAXController@post_chart_data_total'
]);

Route::post('post_chart_data_voting', [
    'as' => 'ajax.post_chart_data_voting',
    'uses' => 'AJAXController@post_chart_data_voting'
]);

Route::post('post_add_question', [
    'as' => 'ajax.post_add_question',
    'uses' => 'AJAXController@post_add_question'
]);

Route::post('post_webinar_share_update', [
    'as' => 'ajax.webinar-share-update',
    'uses' => 'AJAXController@ajaxUpdateWebinarShare'
]);

Route::post('get_webinar_stats', [
    'as' => 'ajax.webinar-stats',
    'uses' => 'AJAXController@ajaxGetWebinarStats'
]);

Route::post('get_webinar_share', [
    'as' => 'ajax.webinar-share',
    'uses' => 'AJAXController@ajaxGetWebinarShare'
]);

Route::post('get_webinar_answered_qa', [
    'as' => 'ajax.webinar-answered-qa',
    'uses' => 'AJAXController@ajaxGetWebinarAnsweredQa'
]);

Route::post('post_update_user_status', [
    'as' => 'ajax.webinar-post_update_user_status',
    'uses' => 'AJAXController@post_update_user_status'
]);

Route::post('post_change_subscriber_name', [
    'as' => 'ajax.change-subscriber-name',
    'uses' => 'AJAXController@post_change_subscriber_name'
]);

Route::post('post_user_status_chart', [
    'as' => 'ajax.webinar-post_user_status_chart',
    'uses' => 'AJAXController@post_user_status_chart'
]);

Route::post('post_panelist_update_question', [
    'as' => 'ajax.panelist-update_question',
    'uses' => 'PanelistAJAXController@post_panelist_update_question'
]);

Route::post('post_panelist_update_answer', [
    'as' => 'ajax.panelist-update_answer',
    'uses' => 'PanelistAJAXController@post_panelist_update_answer'
]);

Route::get('post_export_subscriber_list', [
    'as' => 'ajax.export-post_export_subscriber_list',
    'uses' => 'DatatableAJAXController@post_export_subscriber_list'
]);

Route::get('post_export_subscriber_list_members', [
    'as' => 'ajax.export-post_export_subscriber_list_members',
    'uses' => 'DatatableAJAXController@post_export_subscriber_list_members'
]);

//////////////////////////////////////////////////////QA AJAX controllers
Route::post('post_qa_public_user', [
    'as' => 'ajax-post_qa_public_user',
    'uses' => 'QaAJAXController@post_qa_public_user'
]);

Route::post('post_qa_myqa_user', [
    'as' => 'ajax-post_qa_myqa_user',
    'uses' => 'QaAJAXController@post_qa_myqa_user'
]);

Route::post('post_qa_public_panelist', [
    'as' => 'ajax-post_qa_public_panelist',
    'uses' => 'QaAJAXController@post_qa_public_panelist'
]);

Route::post('post_qa_public_host', [
    'as' => 'ajax-post_qa_public_host',
    'uses' => 'QaAJAXController@post_qa_public_host'
]);