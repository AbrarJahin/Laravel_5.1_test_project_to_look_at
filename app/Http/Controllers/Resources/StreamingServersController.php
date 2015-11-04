<?php

namespace App\Http\Controllers\Resources;

use App\Http\Requests\StoreStreamingServerRequest;
use App\StreamingServer;
use Illuminate\Http\Request;
use App\Http\Requests;
use League\Flysystem\Exception;

class StreamingServersController extends ResourceController
{

    public function __construct() {
        $this->middleware('user.admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $streaming_servers = StreamingServer::paginate(10);
        return $this->view('partials.streaming_servers.index', compact('streaming_servers'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->view('partials.streaming_servers.create', compact('streaming_servers'));

    }

    public function postCreate(StoreStreamingServerRequest $request)
    {
        try{
            $input = $request->input();

            $input['enabled'] = isset($input['enabled']);

            StreamingServer::create($input);

            return redirect()->route('streaming-servers')->with("status", "Streaming Server have been added successfully");

        }catch (Exception $e){
            return redirect()->back()->with("error", "Creation error. Please check your inputs.");

        }

    }

    public function update($id){
        $server = StreamingServer::find($id);
        return $this->view('partials.streaming_servers.edit', compact('server'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postUpdate(StoreStreamingServerRequest $request, $id)
    {
        try{
            $input = $request->input();

            $input['enabled'] = isset($input['enabled']);

            $server = StreamingServer::find($id);
            $server->update($input);

            return redirect()->back()->with("status", "Streaming Server have been successfully updated.");

        }catch (Exception $e){
            return redirect()->back()->with("error", "Creation error. Please check your inputs.");

        }
    }

    public function delete($id){
        StreamingServer::destroy($id);
        return redirect()->route('streaming-servers')->with("status", "Streaming Server have been deleted successfully");
    }


}
