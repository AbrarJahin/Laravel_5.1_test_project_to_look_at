@extends('layouts.member.master')

@section('contents')
    <div class="panel panel-default">
        <div class="panel-heading">Panelists

        <!-- <a href="{!!route('users.panelists.create', [$user->id])!!}"
            class="btn btn-success pull-right">Create New Panelist</a> -->

        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal">Create New Panelist</button>

        <!-- Modal -->
          <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            {!! Form::open(['url' => route('users.panelists.store', $user->id)]); !!}
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Create Panelist</h4>
                </div>

                <div class="modal-body">
                  <div class="form-group">
                    <input type="text" class="form-control" name="name" placeholder="Name">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" name="email" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                  </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" id="submit" value="Create" name="submit" class="btn btn-primary pull-right">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

              </div>
            </form>
            </div>
          </div>

        </div>
        <div class="panel-body">
            <div class="col-md-12">

                <table id="pane_list"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
                    <meta name="base_url" content="{{URL::to('/')}}">
                    <thead>
                        <tr>
                            <th>Name    </th>
                            <th>Email   </th>
                            <th>Status  </th>
                            <th>Action  </th>
                        </tr>
                    </thead>
                </table>
<!--
                <br><br> Delete button doesn't work perfectly, so previous button is not remove, need to have a little discuion for it
                <table class="table table-bordered">
                    <thead>
                        <td width="90px">ID</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td width="80px">Status</td>
                        <td>#</td>
                    </thead>
                    <tbody>
                        @foreach($panelists as $panelist)
                            <tr>
                                <td> {{$panelist->id}} </td>
                                <td> {{$panelist->user->name}} </td>
                                <td> {{$panelist->user->email}} </td>
                                <td> {{$panelist->user->enabled ? 'Active' : 'Inactive'}} </td>
                                <td>
                                    <a style="color:green" 
                                        href="{!!route('users.panelists.edit', [$user->id,$panelist->id])!!}">
                                        <i class="fa fa-pencil fa-2x"></i>
                                    </a>
                                    <a class="delete-resource" style="color:red" 
                                        href="{!!route('users.panelists.destroy',[$user->id,$panelist->id])!!}">
                                        <i class="fa fa-trash fa-3x"></i>
                                    </a>                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
-->
            </div>
            {!!$panelists!!}
        </div>
    </div>
@endsection