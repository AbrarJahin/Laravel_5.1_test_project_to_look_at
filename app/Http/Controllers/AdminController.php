<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

abstract class AdminController extends Controller
{
    public function __construct() {
        $this->middleware('user.admin');
    }
    
    public function view($layout, $data=[]) {

        //include additional data to $data..

        return view($layout,$data);
    }
}
