<?php

namespace App\Http\Controllers\Resources;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\QARequest;
use App\QA;
use App\Http\Requests\PanelistAnswerRequest;

class QAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
    public function store(QARequest $request)
    {
        $webinar = decodeWebinar($request->input('webinars_hash'));
        $subscriber = decodeSubscriber($request->input('subscribers_hash'));
        
        QA::create([
            'webinar_id' => $webinar->id,
            'subscriber_id' => $subscriber->id,
            'question' => $request->input('question'),
            'public' => $request->input('public')
        ]);
        
        return response("Created", 201);
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
    public function update(PanelistAnswerRequest $request, $id)
    {
        $webinar = decodeWebinar($request->input('webinars_hash'));
        $qa = QA::findorFail($id);
        $qa->panelist_id = $request->input("panelist_id");
        $qa->answer = $request->input("answer");
        $qa->save();
        return response(null,204);
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
