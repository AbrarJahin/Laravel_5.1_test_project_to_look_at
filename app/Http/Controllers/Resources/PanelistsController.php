<?php

namespace App\Http\Controllers\Resources;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use \App\Panelist;

use \App\Http\Requests\PanelistsStoreRequest;

class PanelistsController extends ResourceController
{

    public function __construct() {
        $this->middleware('user.customer');
        parent::__construct([]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        $panelists = Panelist::where('customer_id', $userId)->paginate(10);
        return $this->view('partials.panelists.index', compact('panelists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->view('partials.panelists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PanelistsStoreRequest $request, $userId)
    {
        $fields = $request->input();
        $fields['password'] = bcrypt('ufn13d');
        $user = createUser($fields);
        $panelist = new Panelist;
        $panelist->customer_id = $userId;
        $panelist->user_id = $user->id;
        $panelist->save();
        return redirect()->back()->with('status', 'Panelist has been created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($userId,$panelistId)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($userId, $panelistId)
    {
        $panelist = Panelist::find($panelistId);
        return $this->view('partials.panelists.edit', compact('panelist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PanelistsStoreRequest $request, $userId, $panelistId)
    {
        $user = Panelist::find($panelistId)->user()->first();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        return redirect()->back()->with('status', 'panelist updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId, $panelistId)
    {
        $panelist = Panelist::find($panelistId);
        $panelist->user()->delete();
        $panelist->delete();
    }
}
