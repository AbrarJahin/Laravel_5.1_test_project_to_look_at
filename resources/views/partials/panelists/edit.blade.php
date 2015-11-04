@extends('layouts.member.master')

@section('contents')

	<div class="panel panel-default">
		<div class="panel-heading">Edit Panelist ({{$panelist->user->name}})</div>
		<div class="panel-body">
			<div class="col-md-12">
				{!! Form::open(['url' => route('users.panelists.update', [$user->id,$panelist->id]), 'method' => 'PUT']); !!}
					<div class="form-group">
						<input value="{{$panelist->user->name}}" type="text" class="form-control" name="name" placeholder="Name">
					</div>
					<div class="form-group">
						<input value="{{$panelist->user->email}}" type="text" class="form-control" name="email" placeholder="Email">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password" placeholder="Password (leave blank if not changing)">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
					</div>												
					<input type="submit" id="submit" name="submit" class="btn btn-primary pull-right">
				</form>
			</div>
			<div class="col-md-5">
				@include('errors.form')
			</div>
		</div>
	</div>

@endsection