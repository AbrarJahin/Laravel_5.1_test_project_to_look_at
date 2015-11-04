<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

abstract class CustomerLayoutController extends Controller
{
    public function __construct() {
        $this->middleware('user.customer');
    }
    
    public function view($layout, $data) {

        //include additional data to $data..
        //should throw an exception if we already have a variable.
    	$data['user'] = Auth::user();
        $upcoming_webinars = $data['user']->webinars()
            ->where('starts_on', '>', date("Y-m-d H:i:s"))
            ->where('starts_on', '<', date("Y-m-d H:i:s", strtotime('+2 weeks')))
            ->orderBy('starts_on', 'desc')
            ->take(3)
            ->get();

        $data['menu_upcoming_webinars'] = $upcoming_webinars;
        return view($layout,$data);
    }
}
