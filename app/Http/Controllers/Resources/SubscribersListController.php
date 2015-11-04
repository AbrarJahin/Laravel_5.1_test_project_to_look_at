<?php

namespace App\Http\Controllers\Resources;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use \App\SubscribersList;
use \App\User;
use \App\Http\Requests\SubscribersListStoreRequest;
use \Input;

use \App\Webinar;

class SubscribersListController extends ResourceController
{

    public function __construct() {
        $this->middleware('user.customer');
        parent::__construct([]);
    }
    /**
     * Display this list of subscribers of given user id.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        return $this->view('partials.subscribers-lists.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscribersListStoreRequest $request, $userId)
    {
        $fields = Input::except("_token");
        $subscribersList = SubscribersList::create($fields);
        
        $user = \App\User::find($userId);
        $user->subscribers_lists()->save($subscribersList);

        return redirect()->route('users.subscribers-lists.index',$userId)->with('status', "New subscribers list has been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fields = $request->except("_token");
        $subscribersList = SubscribersList::find($id);

        $subscribersList->update([
            'name' => $fields['name']
        ]);

        return redirect()->back()->with('status', "Updated Successful.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
