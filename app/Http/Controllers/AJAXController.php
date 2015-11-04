<?php
namespace App\Http\Controllers;
use App\Subscriber;
use App\Webinar;
use Illuminate\Support\Facades\Input;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\QA;
use App\WebinarLiveAttenders;
use DateTime;

class AJAXController extends Controller
{
//////////////////////For Subscribers of ({Name}}) of /users/3/subscribers-lists/
    public function post_chart_data()
    {
        $requestData = Request::all();

        // Base Quary
        $baseQuery = DB::table('subscribers_lists')
            ->leftjoin('subscribers_lists_subscribers', 'subscribers_lists.id', '=', 'subscribers_lists_subscribers.subscribers_list_id')
            ->leftjoin('subscribers', 'subscribers_lists_subscribers.subscriber_id', '=', 'subscribers.id')
            ->select(
                DB::raw('count(case when subscribers.status = "Active" then 1 else null end) as count_active'),
                DB::raw('count(case when subscribers.status = "Unsubscribed" then 1 else null end) as count_unsubsribers'),
                DB::raw('count(case when subscribers.status = "Bounced" then 1 else null end) as count_bounced')
            )
            ->where('subscribers_lists.user_id', '=', $requestData['user_id'])
            ->where('subscribers_lists_subscribers.subscribers_list_id', '=', $requestData['subscribers_lists_Id']);

        $data=$baseQuery->first();
        $JSON =     array(
                        'Current Active User' => $data->count_active,
                        'Unsubscribed Users' => $data->count_unsubsribers,
                        'Bounced Users' => $data->count_bounced,
                        );
        return $JSON;
    }

    public function post_chart_data_total()
    {
        $requestData = Request::all();

        // Base Quary
        $baseQuery = DB::table('subscribers_lists')
            ->leftjoin('subscribers_lists_subscribers', 'subscribers_lists.id', '=', 'subscribers_lists_subscribers.subscribers_list_id')
            ->leftjoin('subscribers', 'subscribers_lists_subscribers.subscriber_id', '=', 'subscribers.id')
            ->select(
                DB::raw('count(case when subscribers.status = "Active" then 1 else null end) as count_active'),
                DB::raw('count(case when subscribers.status = "Unsubscribed" then 1 else null end) as count_unsubsribers'),
                DB::raw('count(case when subscribers.status = "Bounced" then 1 else null end) as count_bounced')
            )
            ->where('subscribers_lists.user_id', '=', $requestData['user_id']);
            //->where('subscribers_lists_subscribers.subscribers_list_id', '=', $requestData['subscribers_lists_Id']);

        $data=$baseQuery->first();
        $JSON =     array(
                        'Current Active User' => $data->count_active,
                        'Unsubscribed Users' => $data->count_unsubsribers,
                        'Bounced Users' => $data->count_bounced,
                        );
        return $JSON;
    }

    public function post_chart_data_voting()
    {
        $requestData = Request::all();
        $data = DB::table('webinar_vote')->where('webinar_id', '=', $requestData['uuid']);
        if($data->count()>0)
        {
            $data = $data->first();
            $JSON =     array(
                            'Yes Vote' => $data->vote_yes,
                            'No Vote' => $data->vote_no
                        );
        }
        else
        {
            $JSON =     array(
                            'Vote Not Given Yet' => 1
                        );
        }
        return $JSON;
    }

    public function post_add_question()
    {
        $input = Input::all();
        $subscriber_id = $input['subscriber_id'];
        //return $requestData = Request::all();
        $subscriber = Subscriber::find($subscriber_id);
        $qa_to_insert = new QA;

        $qa_to_insert->webinar_id       = Request::input('webinar_id');
        $qa_to_insert->subscriber_id    = $subscriber->id;
        $qa_to_insert->question         = Request::input('question');
        $qa_to_insert->public           = Request::input('public');                           //putting the public value default=1, will change later

        $qa_to_insert->save();

        $dt   = new DateTime();
        $time = $dt->format('Y-m-d H:i:s');

        return array(
                        'question'      => Request::input('question'),
                        'datetime'      => $time,
                        'name'          => $subscriber->first_name.' '.$subscriber->last_name,
                        'ask_before'    => '0 min'
                    );
    }

    public function ajaxUpdateWebinarShare()
    {
        $input = Input::all();
        $webinar = Webinar::find($input['webinarId']);

        $webinar->update([
            'share' => $input['text']
        ]);

        return 'true';
    }

    public function ajaxGetWebinarAnsweredQa()
    {
        $input = Input::all();
        $webinar = Webinar::find($input['webinarId']);
        // Commented by Ronak Shah because As per MR Mock up Unanswered questions will also be displayed
        //$qas = $webinar->qas()->where('answer', '!=', '')->orderBy('updated_at', 'desc')->get();
        $qas = $webinar->qas()->orderBy('updated_at', 'asc')->get();
        return ['questions' => $qas];
    }


    public function ajaxGetWebinarStats()
    {
        $input = Input::all();
        $webinar = Webinar::find($input['webinarId']);

        $response = ['subscribers' => [], 'questions' => [], 'panelists' => []];

        foreach($webinar->subscribers_lists as $list){
            $response['subscribers'][] = ['name' => $list->name, 'count' => $list->subscribers()->count()];
        }

        $response['questions'][] = ['name' => 'Total', 'count' => $webinar->qas->count()];
        $response['questions'][] = ['name' => 'Answered', 'count' => $webinar->qas->where('answer', '!=', '')->count()];
        $response['questions'][] = ['name' => 'Public', 'count' => $webinar->qas->where('public', '=', 1)->count()];

        foreach($webinar->panelists as $panelist){
            $response['panelists'][] = ['name' => $panelist->user->name, 'count' => $panelist->qas->count()];
        }
        return $response;
    }

    public function ajaxGetWebinarShare()
    {
        $input = Input::all();
        $webinar = Webinar::find($input['webinarId']);
        return $webinar->share;
    }

    public function post_update_user_status()
    {
        $requestData    = Request::all();
        $time           = DB::select( DB::raw('SELECT NOW() AS end_time'));
        $current_time   = $time[0]->end_time;
        $client_ip      = Request::getClientIp();
        $webinar_id     = $requestData['uuid'];
        /////////////////////////////////////////////////////////// It is needed because auto date handeling is not possible due to DB backword
        $if_exists = DB::table('webinar_live_attenders')
                        ->where('webinar_id',   '=', $webinar_id)
                        ->where('ip',           '=', $client_ip)
                        ->first();
        if (is_null($if_exists))   // It does not exist - create new entry
        {
            DB::table('webinar_live_attenders')->insert([
                                                            'webinar_id'    => $webinar_id,
                                                            'ip'            => $client_ip,
                                                            'time_on'       => $current_time,
                                                            'last_update'   => $current_time
                                                        ]);
            return 'Added '.$client_ip;
        }
        else                            // It exists - update status
        {
            DB::table('webinar_live_attenders')
                ->where('webinar_id', $webinar_id)
                ->where('ip', $client_ip)
                ->update([
                            'last_update' => $current_time
                        ]);
            return 'Updated '.$client_ip;
        }
        ///////////////////////////////////////////////////////////Previous code - not working because "Current_Timestamps" is not supported
        /*$user_status = WebinarLiveAttenders::firstOrNew([
                                                            'webinar_id' => $requestData['uuid'],
                                                            'ip'         => Request::getClientIp()
                                                        ]);
        $user_status->last_update = $formatted_date;
        $user_status->save();*/
    }

    public function post_user_status_chart()
    {
        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        $requestData = Request::all();
        $webinar_id=$requestData['webinar_id'];
        $no_of_data_to_generate = $requestData['no_of_points'];
        return $this->data_generate($no_of_data_to_generate,$webinar_id);   //No need for encoding again, if just return, it will work fine :)
    }

    public function data_generate($max_no_of_dataset_per_data,$webinar_id)
    {
        $data_to_return=[];
        $line_Name = array(
                                "Current User",
                                "Total User"
                            );
        for ($x = 0; $x <= 1; $x++)
        {
            $data_to_return[] = array(
                                        'name' => $line_Name[$x],
                                        'data' => $this->single_data_generate($max_no_of_dataset_per_data,$webinar_id,$x)
                                    );
        }
        return $data_to_return;
    }

    public function single_data_generate($max_no_of_dataset_per_data,$webinar_id,$data_no)
    {
        $data_to_return=[];
        if($max_no_of_dataset_per_data<5)$max_no_of_dataset_per_data=5;
        ///////////////////////////////////////////////////////////////////////////////////
        $webinar    = Webinar::find($webinar_id);
        $start_time = $webinar['starts_on'];
        $time       = DB::select( DB::raw('SELECT NOW() AS end_time'));
        $end_time   = $time[0]->end_time;//time();
        $start      = strtotime($start_time);
        $end        = strtotime($end_time);
        $interval = ($end-$start)/$max_no_of_dataset_per_data;
        //return date('Y-m-d H:i:s', $interval);
        for ($x = $start; $x <= $end; $x+=$interval)
        {
            $data_to_return[] = $this->one_entry($x,$webinar_id,$data_no);
        }
        ////////////////////////////////////////////////////////////////////////////////////
        /*for ($x = 1; $x <= $max_no_of_dataset_per_data; $x++)
        {
            $data_to_return[] = $this->one_entry($x,$webinar_id,$data_no);
        }*/
        return $data_to_return;
    }

    public function post_change_subscriber_name()
    {
        $input = Input::all();

        $subscriber = Subscriber::findOrNew($input['subscriber_id']);
        $subscriber->update([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name']
        ]);
        return 'true';
    }

    public function one_entry($time_day,$webinar_id,$data_no)
    {
        //date('Y-m-d H:i:s', $time_day);
        $query = DB::table('webinar_live_attenders')
            ->where('webinar_id', $webinar_id);
        if ($data_no==0)    //Current User
        {
            $query = $query->where('last_update', '<=' , date('Y-m-d H:i:s', $time_day));
        }
        else                //Total User
        {
            $query = $query->where('time_on', '<=' , date('Y-m-d H:i:s', $time_day));
        }

        return array(
            'time_year'     => date('Y', $time_day),
            'time_month'    => date('m', $time_day),
            'time_day'      => date('d', $time_day),
            'time_hour'     => date('H', $time_day),
            'time_min'      => date('i', $time_day),
            'time_sec'      => date('s', $time_day),
            'value'         => $query->count()
        );
    }
}
