@extends('layouts.admin.master')

@section('contents')

	<div class="panel panel-default">
		<div class="panel-heading">Create Users</div>
		<div class="panel-body">
			<div class="col-md-5">
				{!! Form::open(['url' => route('users.store')]); !!}
					<div class="form-group">
						<input type="text" class="form-control" id="name" name="name" placeholder="Name">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="email" name="email" placeholder="Email">
					</div>
					<div class="form-group">
						<label for="">Role</label>
						<select name="role_id" class="form-control">
							@foreach($roles as $role)
								<option value="{{$role->id}}">{{$role->display_name}}</option>
							@endforeach
						</select>
					</div>					
					<input type="submit" id="submit" name="submit" class="btn btn-primary pull-right">Submit Form</button>
				</form>
			</div>
			<div class="col-md-5">
				@include('errors.form')
			</div>
		</div>
	</div>

@endsection