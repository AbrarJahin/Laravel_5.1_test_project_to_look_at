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

class QaAJAXController extends Controller
{
    //////////////////////For QA user -> http://localhost/gtwhero/public/webinar/G3AR7NDEONdjgPK9d42b/aPVLJ6705jL5bdA9e1Qg
    public function post_qa_public_user()
    {
    }

    public function post_qa_myqa_user()
    {
    }

    //////////////////////For QA panelist -> http://localhost/gtwhero/public/webinar/G3AR7NDEONdjgPK9d42b/panelist
    public function post_qa_public_panelist()
    {
        $requestData = Request::all();
        return $publicQA = DB::table('qas')
                    ->join('subscribers', 'subscribers.id', '=', 'qas.subscriber_id')
                    ->join('users', 'users.id', '=', 'qas.panelist_id')
                    ->select(
                                'qas.id as question_id',
                                'qas.question as question',
                                DB::raw("CONCAT( subscribers.first_name,' ', subscribers.last_name) as name_question"),
                                DB::raw('NOW() - UNIX_TIMESTAMP(qas.created_at) as question_ask_before'),
                                'qas.answer as answer',
                                'users.name as name_answer',
                                DB::raw('NOW() - UNIX_TIMESTAMP(qas.updated_at) as question_answered_before')
                            )
                    ->where('qas.webinar_id', '=' , $requestData['webinar_id'])
                    //->where('qas.subscriber_id', '=' , $requestData['id'])
                    ->where('qas.public', '=' , 1)
                    ->orderBy('qas.updated_at', 'desc')
                    ->take(100)->get();
    }

    //////////////////////For QA Host -> http://localhost/gtwhero/public/members/webinar/G3AR7NDEONdjgPK9d42b
    public function post_qa_public_host()
    {
    }
}
