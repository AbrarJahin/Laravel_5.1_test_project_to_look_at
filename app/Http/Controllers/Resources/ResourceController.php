<?php

namespace App\Http\Controllers\Resources;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use \App\User;
use \App\Webinar;

abstract class ResourceController extends Controller
{
	private $extra = [];

    public function __construct($data = []) {    	
    	$this->extra = $data;
    	$user = Auth::user();
        if(is_null($user)){
            return redirect('auth/login');
        }
    	//$request = \App::make('Illuminate\Http\Request');    	
        //$user = User::find($request->route('users'));

		$upcoming_webinars = $user->webinars()
				->where('starts_on', '>', date("Y-m-d H:i:s"))
				->where('starts_on', '<', date("Y-m-d H:i:s", strtotime('+2 weeks')))
				->orderBy('starts_on', 'desc')
				->take(3)
				->get();

		$this->extra['menu_upcoming_webinars'] = $upcoming_webinars;
        $this->extra['user'] = $user;
        // Non Webinar Subscribers Lists
        $this->extra['subscribersLists'] = $user->subscribers_lists()->where("webinar_id", "=", NULL)->get();
    	
    	$this->middleware('auth');
    }

    public function view($viewName, $data = []) {
    	$data = array_merge($data,$this->extra);
    	return view($viewName, $data);
    }
}
