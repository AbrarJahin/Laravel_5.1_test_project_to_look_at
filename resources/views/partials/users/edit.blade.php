@extends('layouts.admin.master')

@section('contents')

	<div class="panel panel-default">
		<div class="panel-heading">Create Users</div>
		<div class="panel-body">
			<div class="col-md-5">
				{!! Form::open(['url' => route('users.update', $user->id), 'method' => 'PUT']); !!}
					<div class="form-group">
						<input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{!!$user->name!!}">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{!!$user->email!!}">
					</div>
					<div class="form-group">
						<label for="">Role</label>
						<select name="role_id" class="form-control">
							@foreach($roles as $role)
								<option value="{{$role->id}}">{{$role->display_name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="">Enabled <input name="enabled" @if($user->enabled) checked @endif type="checkbox"></label>
					</div>
					<input type="submit" id="submit" name="submit" class="btn btn-primary pull-right" />
				</form>
			</div>
			<div class="col-md-5">
				@include('errors.form')
			</div>
		</div>
	</div>

@endsection