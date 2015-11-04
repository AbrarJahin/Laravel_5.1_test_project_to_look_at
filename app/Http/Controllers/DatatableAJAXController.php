<?php
namespace App\Http\Controllers;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Auth;
use App\QA;

class DatatableAJAXController extends CustomerLayoutController
{
    ////////////////////////////////////////////////////////////Exporting data in CSV
    public function post_export_subscriber_list()
    {
        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
        $columns = array(
                        "List Name",
                        "Count Openers",
                        "Count Clickers",
                        "Count Active",
                        "Count Unsubscribers",
                        "Count Bounce",
                        "Count Total",
                        "Last Activity"
                    );
        $csv->insertOne($columns);

        $baseQuery = DB::table('subscribers_lists')
            ->leftjoin('subscribers_lists_subscribers', 'subscribers_lists.id', '=', 'subscribers_lists_subscribers.subscribers_list_id')
            ->leftjoin('subscribers', 'subscribers_lists_subscribers.subscriber_id', '=', 'subscribers.id')
            ->select(
                'subscribers_lists.name',
                'subscribers_lists.id as count_openers',
                'subscribers_lists.id as count_clickers',
                DB::raw('count(case when subscribers.status = "Active" then 1 else null end) as count_active'),
                DB::raw('count(case when subscribers.status = "Unsubscribed" then 1 else null end) as count_unsubsribers'),
                DB::raw('count(case when subscribers.status = "Bounced" then 1 else null end) as count_bounced'),
                DB::raw('count(subscribers_lists_subscribers.subscribers_list_id) as count_total'),
                'subscribers_lists.updated_at as last_activity'
            )
            ->where('subscribers_lists.user_id', '=', Auth::user()->id)
            ->groupBy('subscribers_lists.id')
            ->get();
        foreach ($baseQuery as $value)
        {
            $temp_data = array(
                                    $value->name,
                                    $value->count_openers,
                                    $value->count_clickers,
                                    $value->count_active,
                                    $value->count_unsubsribers,
                                    $value->count_bounced,
                                    $value->count_total,
                                    $value->last_activity
                                );
            $csv->insertOne($temp_data);
        }

        $current_time = Carbon::now();
        $csv->output('subscriber_list_'.$current_time->toDateTimeString().'.csv');
    }

    public function post_export_subscriber_list_members()
    {
        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
        $columns = array(
                        "List Name",
                        "Count Openers",
                        "Count Clickers",
                        "Count Active",
                        "Count Unsubscribers",
                        "Count Bounce",
                        "Count Total",
                        "Last Activity"
                    );
        $csv->insertOne($columns);

        $baseQuery = DB::table('subscribers_lists')
            ->leftjoin('subscribers_lists_subscribers', 'subscribers_lists.id', '=', 'subscribers_lists_subscribers.subscribers_list_id')
            ->leftjoin('subscribers', 'subscribers_lists_subscribers.subscriber_id', '=', 'subscribers.id')
            ->select(
                'subscribers_lists.name',
                'subscribers_lists.id as count_openers',
                'subscribers_lists.id as count_clickers',
                DB::raw('count(case when subscribers.status = "Active" then 1 else null end) as count_active'),
                DB::raw('count(case when subscribers.status = "Unsubscribed" then 1 else null end) as count_unsubsribers'),
                DB::raw('count(case when subscribers.status = "Bounced" then 1 else null end) as count_bounced'),
                DB::raw('count(subscribers_lists_subscribers.subscribers_list_id) as count_total'),
                'subscribers_lists.updated_at as last_activity'
            )
            ->whereNull('subscribers_lists.webinar_id')
            ->groupBy('subscribers_lists.id')
            ->get();
        foreach ($baseQuery as $value)
        {
            $temp_data = array(
                                    $value->name,
                                    $value->count_openers,
                                    $value->count_clickers,
                                    $value->count_active,
                                    $value->count_unsubsribers,
                                    $value->count_bounced,
                                    $value->count_total,
                                    $value->last_activity
                                );
            $csv->insertOne($temp_data);
        }

        $current_time = Carbon::now();
        $csv->output('subscriber_list_members_'.$current_time->toDateTimeString().'.csv');
    }
    /////////////////////////////////End Exporting///////////////////////////////////////

//////////////////////For Subscribers of ({Name}}) of /users/{user_id}/subscribers-lists/
    public function ajax_subscribers_list()
    {
        $requestData = Request::all();

        $columns = array(
            // datatable column index  => database column name
            0 => 'subscribers_lists.name',
            1 => 'subscribers_lists.id',
            2 => 'subscribers_lists.id',
            3 => 'subscribers_lists.name',
            4 => 'subscribers_lists.name',
            5 => 'subscribers_lists.name',
            6 => 'subscribers_lists.name',
            7 => 'subscribers_lists.updated_at'
        );

        $draw_request_code = $requestData['draw'];
        $searchParameter = $requestData['search']['value'];
        $order_by_value = $columns[$requestData['order'][0]['column']];
        $orderingDirection = $requestData['order'][0]['dir'];
        $limit_start = $requestData['start'];
        $limit_interval = $requestData['length'];
        $user_ID = $requestData['user_id_of_current_page'];

        // Base Quary
        $baseQuery = DB::table('subscribers_lists')
            ->leftjoin('subscribers_lists_subscribers', 'subscribers_lists.id', '=', 'subscribers_lists_subscribers.subscribers_list_id')
            ->leftjoin('subscribers', 'subscribers_lists_subscribers.subscriber_id', '=', 'subscribers.id')
            ->select(
                'subscribers_lists.id',
                'subscribers_lists.name',
                'subscribers_lists.id as count_openers',
                'subscribers_lists.id as count_clickers',
                DB::raw('count(case when subscribers.status = "Active" then 1 else null end) as count_active'),
                DB::raw('count(case when subscribers.status = "Unsubscribed" then 1 else null end) as count_unsubsribers'),
                DB::raw('count(case when subscribers.status = "Bounced" then 1 else null end) as count_bounced'),
                DB::raw('count(subscribers_lists_subscribers.subscribers_list_id) as count_total'),
                'subscribers_lists.updated_at as last_activity'
            )
            ->where('subscribers_lists.user_id', '=', $user_ID)
            ->groupBy('subscribers_lists.id');

        $finding_total_query = DB::table('subscribers_lists')->where('subscribers_lists.user_id', '=', $user_ID);
        $totalData = $finding_total_query->count();

        //Applying Filters

        ////Search Filtering
        $filtered_query = $baseQuery;
        if (!empty($searchParameter))
        {
            $filtered_query = $filtered_query->where('subscribers_lists.name', 'like', '%' . $searchParameter . '%');
            $finding_total_query =$finding_total_query->where('subscribers_lists.name', 'like', '%' . $searchParameter . '%');
        }

        $totalFiltered = $finding_total_query->count();

        //Ordering
        $filtered_query = $filtered_query->orderBy($order_by_value, $orderingDirection);
        //Limiting for Pagination
        $data = $filtered_query->skip($limit_start)->take($limit_interval)->get();

        $json_data = array(
            "draw" => intval($draw_request_code),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($totalData),  // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data   // total data array
        );

        return $json_data;
    }

//////////////////////For Subscribers of ({Name}}) of /users/3/subscribers-lists/1/subscribers
    public function subscribers_names()
    {
        $requestData = Request::all();

        $columns = array(
            // datatable column index  => database column name
            0 => 'subscribers.id',
            1 => 'subscribers.first_name',
            2 => 'subscribers.last_name',
            3 => 'subscribers.email',
            4 => 'subscribers.status',
            5 => 'subscribers.uuid',
            6 => 'subscribers.updated_at'
        );

        $draw_request_code = $requestData['draw'];
        $searchParameter = $requestData['search']['value'];
        $order_by_value = $columns[$requestData['order'][0]['column']];
        $orderingDirection = $requestData['order'][0]['dir'];
        $limit_start = $requestData['start'];
        $limit_interval = $requestData['length'];
        $user_ID = $requestData['user_id_of_current_page'];
        $subscribers_lists_Id = $requestData['subscribers_lists_Id'];

        // Base Quary
        $baseQuery = DB::table('subscribers_lists_subscribers')
            ->join('subscribers', 'subscribers.id', '=', 'subscribers_lists_subscribers.subscriber_id')
            ->select(
                'subscribers.id',
                'subscribers.first_name',
                'subscribers.last_name',
                'subscribers.email',
                'subscribers.status',
                'subscribers.uuid',    
                'subscribers.updated_at'
            )
            ->where('subscribers_lists_subscribers.subscribers_list_id', '=', $subscribers_lists_Id);

        $totalData = $baseQuery->count();

        //Applying Filters

        ////Search Filtering
        $filtered_query = $baseQuery;
        if (!empty($searchParameter))
        {
            $filtered_query = $filtered_query
                                    ->where(function($query) use ($searchParameter)
                                    {
                                        $query->where('subscribers.first_name', 'like', '%'.$searchParameter.'%')
                                        ->orWhere('subscribers.last_name', 'like', '%'.$searchParameter.'%')
                                        ->orWhere('subscribers.email', 'like', '%' . $searchParameter . '%');
                                    });
        }

        $totalFiltered = $filtered_query->count();

        //Ordering
        $filtered_query = $filtered_query->orderBy($order_by_value, $orderingDirection);
        //Limiting for Pagination
        $data = $filtered_query->skip($limit_start)->take($limit_interval)->get();

        $json_data = array(
            "draw" => intval($draw_request_code),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($totalData),  // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data   // total data array
        );

        return $json_data;
    }

////////////////////////////////Datatable AJAX request for URL = "users/{user_id}/panelists"
    public function ajax_pane_list()
    {
        $requestData = Request::all();

        $columns = array(
            // datatable column index  => database column name
            0 => 'users.id',
            1 => 'users.name',
            2 => 'users.email',
            3 => 'users.enabled'
        );

        $draw_request_code = $requestData['draw'];
        $searchParameter = $requestData['search']['value'];
        $order_by_value = $columns[$requestData['order'][0]['column']];
        $orderingDirection = $requestData['order'][0]['dir'];
        $limit_start = $requestData['start'];
        $limit_interval = $requestData['length'];
        $user_ID = $requestData['user_id_of_current_page'];

        // Base Quary
        $baseQuery = DB::table('panelists')
            ->join('users', 'panelists.user_id', '=', 'users.id')
            ->select(
                'panelists.id',
                'users.name',
                'users.email',
                DB::raw('IF(enabled=1,"Active","Inactive")AS status')
            )
            ->where('panelists.customer_id', '=', $user_ID);

        $totalData = $baseQuery->count();

        //Applying Filters

        ////Search Filtering
        $filtered_query = $baseQuery;
        if (!empty($searchParameter))
        {
            $filtered_query = $filtered_query
                                    ->where(function($query) use ($searchParameter)
                                    {
                                        $query
                                            ->where('users.name', 'like', '%'.$searchParameter.'%')
                                            ->orWhere('users.email', 'like', '%' . $searchParameter . '%');
                                    });
        }

        $totalFiltered = $filtered_query->count();

        //Ordering
        $filtered_query = $filtered_query->orderBy($order_by_value, $orderingDirection);
        //Limiting for Pagination
        $data = $filtered_query->skip($limit_start)->take($limit_interval)->get();

        $json_data = array(
            "draw" => intval($draw_request_code),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($totalData),  // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data   // total data array
        );

        return $json_data;
    }

////////////////////////////////Datatable AJAX request for URL = "users/{user_id}/webinars" -> upcoming
    public function ajax_upcoming_webinars_list()
    {
        $requestData = Request::all();

        $columns = array(
            // datatable column index  => database column name
            0 => 'webinars.id',
            1 => 'webinars.title',
            2 => 'webinars.starts_on',
            3 => 'webinars.created_at'
        );

        $draw_request_code = $requestData['draw'];
        $searchParameter = $requestData['search']['value'];
        $order_by_value = $columns[$requestData['order'][0]['column']];
        $orderingDirection = $requestData['order'][0]['dir'];
        $limit_start = $requestData['start'];
        $limit_interval = $requestData['length'];
        $user_ID = $requestData['user_id_of_current_page'];

        // Base Quary
        $baseQuery = DB::table('webinars')
            //->join('users', 'panelists.user_id', '=', 'users.id')
            ->select(
                        'webinars.id as webinar_id',
                        'webinars.title',
                        'webinars.description',
                        'webinars.hosts',
                        DB::raw('concat(DATE_FORMAT(starts_on,"%d %b %Y %h:%i %p"), " ", timezone) as starts'),
                        'webinars.duration',
                        'webinars.created_at',
                        'webinars.uuid as id'
                    )
            ->where('user_id', '=', $user_ID)
            ->whereRaw('starts_on >= NOW()');

        $totalData = $baseQuery->count();

        //Applying Filters

        ////Search Filtering
        $filtered_query = $baseQuery;
        if (!empty($searchParameter))
        {
            $filtered_query = $filtered_query
                                    ->where(function($query) use ($searchParameter)
                                    {
                                        $query
                                            ->where(    'webinars.title',       'like', '%' .   $searchParameter . '%')
                                            ->orWhere(  'webinars.description', 'like', '%' .   $searchParameter . '%')
                                            ->orWhere(  'webinars.hosts',       'like', '%' .   $searchParameter . '%');
                                    });
        }

        $totalFiltered = $filtered_query->count();

        //Ordering
        $filtered_query = $filtered_query->orderBy($order_by_value, $orderingDirection);
        //Limiting for Pagination
        $data = $filtered_query->skip($limit_start)->take($limit_interval)->get();

        foreach($data as $k=>$row){
            $data[$k]->title = '<b>'.$data[$k]->title.'</b> by <b>'.$data[$k]->hosts.'</b><br />'.$data[$k]->description;
            $data[$k]->starts = $data[$k]->starts.'<br /> Estimated duration '.$data[$k]->duration.'h';
        }

        $json_data = array(
            "draw" => intval($draw_request_code),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($totalData),  // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data   // total data array
        );

        return $json_data;
    }

////////////////////////////////Datatable AJAX request for URL = "users/{user_id}/webinars" -> past
    public function ajax_past_webinars_list()
    {
        $requestData = Request::all();

        $columns = array(
            // datatable column index  => database column name
            0 => 'webinars.id',
            1 => 'webinars.title',
            2 => 'webinars.starts_on',
            3 => 'webinars.created_at'
        );

        $draw_request_code = $requestData['draw'];
        $searchParameter = $requestData['search']['value'];
        $order_by_value = $columns[$requestData['order'][0]['column']];
        $orderingDirection = $requestData['order'][0]['dir'];
        $limit_start = $requestData['start'];
        $limit_interval = $requestData['length'];
        $user_ID = $requestData['user_id_of_current_page'];

        // Base Quary
        $baseQuery = DB::table('webinars')
            //->join('users', 'panelists.user_id', '=', 'users.id')
            ->select(
                        'webinars.id as webinar_id',
                        'webinars.title',
                        'webinars.description',
                        'webinars.hosts',
                        DB::raw('concat(DATE_FORMAT(starts_on,"%d %b %Y %h:%i %p"), " ", timezone) as starts'),
                        'webinars.duration',
                        'webinars.created_at',
                        'webinars.uuid as id'
                    )
            ->where('user_id', '=', $user_ID)
            ->whereRaw('starts_on < NOW()');

        $totalData = $baseQuery->count();

        //Applying Filters

        ////Search Filtering
        $filtered_query = $baseQuery;
        if (!empty($searchParameter))
        {
            $filtered_query = $filtered_query
                                    ->where(function($query) use ($searchParameter)
                                    {
                                        $query
                                            ->where(    'webinars.title',       'like', '%' .   $searchParameter . '%')
                                            ->orWhere(  'webinars.description', 'like', '%' .   $searchParameter . '%')
                                            ->orWhere(  'webinars.hosts',       'like', '%' .   $searchParameter . '%');
                                    });
        }

        $totalFiltered = $filtered_query->count();

        //Ordering
        $filtered_query = $filtered_query->orderBy($order_by_value, $orderingDirection);
        //Limiting for Pagination
        $data = $filtered_query->skip($limit_start)->take($limit_interval)->get();

        foreach($data as $k=>$row){
            $data[$k]->title = '<b>'.$data[$k]->title.'</b> by <b>'.$data[$k]->hosts.'</b><br />'.$data[$k]->description;
            $data[$k]->starts = $data[$k]->starts.'<br /> Estimated duration '.$data[$k]->duration.'h';
        }

        $json_data = array(
            "draw" => intval($draw_request_code),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($totalData),  // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data   // total data array
        );

        return $json_data;
    }

///////////////////////Delete functions///////////////////////////////////////////////////////////////////////
    public function delete_subscribers()
    {
        $requestData = Request::all();
        $query_select = DB::table('subscribers_lists_subscribers')
                            ->where('subscribers_list_id', '=',  $requestData['list_id'])
                            ->where('subscriber_id',        '=', $requestData['subscriber_id']);
        if($query_select->delete())
            return "Succesfully deleted";
        else
            return "Delete Failed";
    }

    public function delete_panelists()
    {
        $requestData = Request::all();
        $query_select = DB::table('panelists')
                            ->where('customer_id', '=',  $requestData['user_id'])
                            ->where('id',        '=', $requestData['panelist_id']);
        if($query_select->delete())
            return "Succesfully deleted";
        else
            return "Delete Failed";
    }

    public function delete_webinars()
    {
        //return Auth::
        $requestData = Request::all();
        $query_select = DB::table('webinars')
                            ->where('user_id', '=',  $requestData['user_id'])
                            ->where('uuid',    '=',  $requestData['uuid']);
        if($query_select->delete())
            return "Succesfully deleted";
        else
            return "Delete Failed";
    }

//////////////////////For Subscribers of ({Name}}) of /users/3/subscribers-lists/
    public function ajax_subscribers_list_by_members()
    {
        $requestData = Request::all();

        $columns = array(
            // datatable column index  => database column name
            0 => 'subscribers_lists.name',
            1 => 'subscribers_lists.id',
            2 => 'subscribers_lists.id',
            3 => 'subscribers_lists.name',
            4 => 'subscribers_lists.name',
            5 => 'subscribers_lists.name',
            6 => 'subscribers_lists.name',
            7 => 'subscribers_lists.updated_at'
        );

        $draw_request_code = $requestData['draw'];
        $searchParameter = $requestData['search']['value'];
        $order_by_value = $columns[$requestData['order'][0]['column']];
        $orderingDirection = $requestData['order'][0]['dir'];
        $limit_start = $requestData['start'];
        $limit_interval = $requestData['length'];
        $user_ID = $requestData['user_id_of_current_page'];

        // Base Quary
        $baseQuery = DB::table('subscribers_lists')
            ->leftjoin('subscribers_lists_subscribers', 'subscribers_lists.id', '=', 'subscribers_lists_subscribers.subscribers_list_id')
            ->leftjoin('subscribers', 'subscribers_lists_subscribers.subscriber_id', '=', 'subscribers.id')
            ->select(
                'subscribers_lists.id',
                'subscribers_lists.name',
                'subscribers_lists.id as count_openers',
                'subscribers_lists.id as count_clickers',
                DB::raw('count(case when subscribers.status = "Active" then 1 else null end) as count_active'),
                DB::raw('count(case when subscribers.status = "Unsubscribed" then 1 else null end) as count_unsubsribers'),
                DB::raw('count(case when subscribers.status = "Bounced" then 1 else null end) as count_bounced'),
                DB::raw('count(subscribers_lists_subscribers.subscribers_list_id) as count_total'),
                'subscribers_lists.updated_at as last_activity'
            )
            ->whereNull('subscribers_lists.webinar_id')
            //->where('subscribers_lists.webinar_id', 'IS', 'NULL')
            ->groupBy('subscribers_lists.id');

        $finding_total_query  = DB::table('subscribers_lists')->whereNull('subscribers_lists.webinar_id');
        $totalData            = $finding_total_query->count();

        //Applying Filters

        ////Search Filtering
        $filtered_query = $baseQuery;
        if (!empty($searchParameter))
        {
            $filtered_query = $filtered_query->where('subscribers_lists.name', 'like', '%' . $searchParameter . '%');
            $finding_total_query->where('subscribers_lists.name', 'like', '%' . $searchParameter . '%');
        }
        $totalFiltered        = $finding_total_query->count();
        //Ordering
        $filtered_query = $filtered_query->orderBy($order_by_value, $orderingDirection);
        //Limiting for Pagination
        $data = $filtered_query->skip($limit_start)->take($limit_interval)->get();

        $json_data = array(
            "draw" => intval($draw_request_code),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($totalData),  // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data   // total data array
        );

        return $json_data;
    }

}
