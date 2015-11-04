<?php
namespace App\Http\Controllers;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\QA;
use Carbon\Carbon;
use DateTime;
use Auth;

class PanelistAJAXController extends Controller
{
    //It is not working, so working in a different way
    /*
    function __construct()
    {
        $this->middleware('user.panelist');
    }
    */

    public function post_panelist_update_question()
    {//I am running query builder insted of using Model because of making the AJAX faster by only providing the required data
        $requestData = Request::all();
        return DB::table('qas')
                    ->join('subscribers', 'subscribers.id', '=', 'qas.subscriber_id')
                    ->select(
                                'qas.question as question',
                                'qas.answer as answer',
                                DB::raw("CONCAT( subscribers.first_name,' ', subscribers.last_name) as name"),
                                DB::raw('NOW() - UNIX_TIMESTAMP(qas.created_at) as question_ask_before')
                                //DB::raw("DATE_FORMAT(NOW() - qas.created_at, '%Y-%m-%d %H:%i:%s') as question_ask_before")   // as question_ask_before
                            )
                    ->where('qas.id', '=' , $requestData['id'])
                    ->get();
    }

    public function post_panelist_update_answer()
    {
        $requestData = Request::all();
        $dt   = new DateTime();
        $time = $dt->format('Y-m-d H:i:s');

        $qa = QA::find($requestData['qa_id']);
        $qa->answer     = $requestData['answer'];
        $qa->public     = $requestData['private_public'];
        $qa->updated_at = $time;
        $qa->panelist_id = Auth::user()->id;
        $qa->save();
        if($requestData['private_public']==0)
            return "Successfully Updated Answer by Private";
        else
            return "Successfully Updated Answer by Public";
    }
}
