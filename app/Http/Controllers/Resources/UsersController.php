<?php

namespace App\Http\Controllers\Resources;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use \App\User;
use \Input;
use \App\Role;
use App\Http\Requests\StoreUsersRequest;

class UsersController extends ResourceController
{

    public function __construct()
    {
        $this->middleware('user.admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = [];
        
        if(Input::has('role')) {
            $users = \DB::table('users')->join('role_user', 'role_user.user_id', '=', 'users.id')->join('roles', 'roles.id', '=', 'role_user.role_id')->where('roles.name', Input::get("role"))->select('users.id', 'users.name', 'users.email', 'users.enabled', 'roles.name as role')->orderBy('users.id', 'desc')->paginate(10);
        } else {
            $users = \DB::table('users')->join('role_user', 'role_user.user_id', '=', 'users.id')->join('roles', 'roles.id', '=', 'role_user.role_id')->select('users.id', 'users.name', 'users.email', 'users.enabled', 'roles.name as role')->orderBy('users.id', 'desc')->paginate(10);
        }
        $users = $users->appends(Input::except('page'));        

        return $this->view('partials.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return $this->view('partials.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersRequest $request)
    {
        $fields = Input::except('_token');
        $fields['password'] = bcrypt('ufn13d');
        $user = createUser($fields);
        $user->roles()->attach($fields['role_id']);
        return redirect()->route('users.index');
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
        $user = User::findOrFail($id);

        $roles = Role::all();
        return $this->view('partials.users.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUsersRequest $request, $id)
    {
        $user = User::find($id);
        $fields = Input::all();
        $fields['enabled'] = Input::has('enabled') ? 1 : 0;
        $user->fill($fields);
        $user->save();
        return redirect()->back()->with('status', 'Profile updated');
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
