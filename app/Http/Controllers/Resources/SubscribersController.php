<?php

namespace App\Http\Controllers\Resources;

use Illuminate\Http\Request;
use App\Http\Requests\SubscriberStoreRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Subscriber;
use App\SubscribersList;
use \App\User;
use \App\Webinar;

use \Input;

class SubscribersController extends ResourceController
{

    public function __construct(Request $request) {
        $this->middleware('user.customer');
        $userId = $request->route('users');
        $subscribersListId = $request->route('subscribers_lists');
        $subscriberId = $request->route("subscribers");
        $user = User::findOrFail($userId);
        $subscribersLists = $user->subscribers_lists()->get();
        $subscribersList = SubscribersList::findOrFail($subscribersListId);
        parent::__construct(compact('subscribersLists','userId','subscribersListId',
            'subscriberId', 'subscribersList'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId,$subscribersListId)
    {
        $subscribers = SubscribersList::findOrFail($subscribersListId)
                            ->subscribers()
                            ->orderBy('id','desc')
                            ->paginate(10);

        return $this->view('partials.subscribers-lists.subscribers.index',
            compact('subscribers'));
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
     * Stores bulk subscribers create request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request, $userId, $subscribersListId)
    {
        $subscribers = Input::get('subscribers');
        $list = SubscribersList::find($subscribersListId);        
        
        foreach ($subscribers as $subscriber) {

            if($list->subscribers()->where('email',$subscriber['email'])->count() == 0) {
                $subscriber['status'] = 'Active';
                $subscriber = Subscriber::create($subscriber);
                $subscriber->uuid = hashSubscriber($subscriber->id);
                $subscriber->save();
                $subscriber->subscribers_lists()->attach($subscribersListId);
            }
        }
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
    public function edit($userId, $subscribersListId, $subscriberId)
    {
       $subscriber = Subscriber::findOrFail($subscriberId);
       return $this->view('partials.subscribers-lists.subscribers.edit',compact('subscriber'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubscriberStoreRequest $request, $userId,$subscribersListId, $subscriberId)
    {
        $subscriber = Subscriber::findOrFail($subscriberId);
        $subscriber->fill($request->input());
        $subscriber->save();
        return redirect()->back()->with('status', "Subscriber's detail updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Subscriber::findOrFail($id)->delete();
    }
}
