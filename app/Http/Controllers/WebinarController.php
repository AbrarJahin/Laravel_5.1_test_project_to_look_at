<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use \App\WebinarVote;
use \App\Webinar;
use App\User;
use App\WebinarLead;
use App\Subscriber;
use App\Http\Requests;
use DB;
use Auth;

class WebinarController extends Controller
{
    function index($webinar_uuid = null, $hash)
    {
        $subscriber = decodeSubscriber($hash);
        if(!$subscriber){
            return redirect()->route("site.webinar.lp", [$webinar_uuid]);
        }
    	$webinar = Webinar::where('uuid', '=',$webinar_uuid)->first();
        if(!$webinar){
            abort(404);
        }
        $streamingServer = $webinar->streaming_server()->first();
        //$ownQas = $subscriber->qas($webinar->id)->get();
        $ownQas = DB::table('qas')
                    ->join('subscribers', 'subscribers.id', '=', 'qas.subscriber_id')
                    ->select(
                                'qas.question as question',
                                'qas.created_at as question_datetime',
                                'subscribers.first_name as first_name',
                                'subscribers.last_name as last_name',
                                DB::raw('NOW() - UNIX_TIMESTAMP(qas.created_at) as question_ask_before'),
                                'qas.answer as answer'
                            )
                    ->where('qas.webinar_id', '=' , $webinar['id'])
                    ->where('qas.subscriber_id', '=' , $subscriber->id)
                    ->get();
        $publicQA = DB::table('qas')
                    ->join('subscribers', 'subscribers.id', '=', 'qas.subscriber_id')
                    ->select(
                                'qas.question as question',
                                'qas.created_at as question_datetime',
                                'subscribers.first_name as first_name',
                                'subscribers.last_name as last_name',
                                DB::raw('NOW() - UNIX_TIMESTAMP(qas.created_at) as question_ask_before'),
                                'qas.answer as answer'
                            )
                    ->where('qas.webinar_id', '=' , $webinar['id'])
                    ->where('qas.subscriber_id', '<>' , $subscriber->id)
                    ->where('qas.public', '=' , 1)
                    ->get();
        
        $is_panelist = false;

        return view('layouts.webinar.index', compact('publicQA','webinar', 'subscriber', 'ownQas', 'is_panelist', 'streamingServer'));
    }

    function webinar($webinar_uuid)
    {
        $webinar = Webinar::where('uuid', '=',$webinar_uuid)->first();
        $streamingServer = $webinar->streaming_server()->first();
        $is_panelist = true;
        $subscriber=NULL;
        /*
        if(!$webinar)           //I don't think it is needed
        {
            die("No Webinar Found");
        }
        */
        $publicQA = DB::table('qas')
                    ->join('users', 'users.id', '=', 'qas.subscriber_id')
                    ->select(
                                'qas.id',
                                'qas.question as question',
                                'qas.created_at as question_datetime',
                                'users.name as question_name',
                                DB::raw('NOW() - UNIX_TIMESTAMP(qas.created_at) as question_ask_before'),
                                'qas.answer as answer'
                            )
                    ->where('qas.webinar_id', '=' , $webinar['id'])
                    ->where('qas.public', '=' , 1)
                    ->get();

        return view('layouts.webinar.panelist_main', compact('subscriber','webinar', 'is_panelist', 'streamingServer', 'publicQA'));
    }

    function landingPage($webinar_uuid)
    {
        $webinar = Webinar::where('uuid', '=',$webinar_uuid)->first();
        return view('layouts.webinar.landing_page', compact('webinar'));
    }

    function addLead(Request $request)
    {
        if($request->ajax()){
            $input = $request->all();
            $webinar_id = $input['webinar_id'];
            $first_name = $input['first_name'];
            $last_name = $input['last_name'];
            $email = $input['email'];
            $response = array();
            
            $rules = [
                'webinar_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email'
            ];
            
            $validator = Validator::make($input, $rules);
            
            if($validator->passes()){
                
                $webinar = Webinar::find($webinar_id);
                if($webinar){
                    $subscriber = Subscriber::whereEmail($email)->first();
                    if(!$subscriber){
                        $insert = [
                            "first_name" => $first_name,
                            "last_name" => $last_name,
                            "email" => $email,
                            "status" => "Active"
                        ];
                        $subscriber = Subscriber::create($insert);
                    }
                    
                    $webinar_signup_subscribers_lists = $webinar->signup_subscribers_lists()->get();
                    foreach($webinar_signup_subscribers_lists as $webinar_list){
                        // Attach New Subscriber with Webinar
                        $webinar_list->subscribers()->detach($subscriber->id);
                        $webinar_list->subscribers()->attach($subscriber->id);
                    }
                    
                    $response = array('success' => true);
                } else {
                    $errors = array("Webinar Not Found");
                    $response = array('success' => false, 'errors' => $errors);
                }
            } else {
                $errors = $validator->getMessageBag()->toArray();
                $response = array('success' => false, 'errors' => $errors);
            }
            
            echo json_encode($response);
        }
    }

    function reset_votes(Request $request)
    {
        $input = $request->all();
        WebinarVote::destroy($input['uuid']);
        return 'Vote Reset Successful !!';
    }

    function add_votes(Request $request)
    {
        $input = $request->all();
        /*if('yes'==$input['yes_no_value'])
        {
            WebinarVote::firstOrCreate([
                                        'webinar_id' => $input['uuid']
                                    ])->increment('vote_yes');
        }
        else
        {
            WebinarVote::firstOrCreate([
                                        'webinar_id' => $input['uuid']
                                    ])->increment('vote_no');
        }*/

        $webinar_vote = WebinarVote::firstOrNew(['webinar_id' => $input['uuid']]); 

        if('yes'== $input['yes_no_value'])
        {
            $webinar_vote->vote_yes = $webinar_vote->vote_yes + 1;
        }
        else
        {        
            $webinar_vote->vote_no = $webinar_vote->vote_no + 1;
        }

        $webinar_vote->save();

        return 'Vote Given Successfully !!';
    }
}