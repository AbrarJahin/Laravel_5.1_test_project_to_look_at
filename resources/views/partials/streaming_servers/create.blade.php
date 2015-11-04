@extends('layouts.admin.master')

@section('contents')
	@include('errors.form')

	<div class="panel panel-default">
		<div class="panel-heading">New Streaming Server</div>
		<div class="panel-body">
			<div class="col-md-12">
				{!! Form::open(['url' => route('streaming-servers.create.post')]) !!}
				<div class="form-group">
					<label for="name">Server Name</label>
					<input type="text" class="form-control" id="name" name="name" placeholder="Server Name">
				</div>
				<div class="form-group">
					<label for="name">Streaming URL</label>
					<input type="text" class="form-control" id="streaming_url" name="streaming_url"
						   placeholder="Streaming URL">
				</div>
				<div class="form-group">
					<label for="name">Access Level</label>
					<input type="text" class="form-control" id="access_level" name="access_level"
						   placeholder="Access Level">
				</div>
				<div class="form-group">
					<input type="checkbox" id="enabled" name="enabled" >
					<label for="enabled">Enabled</label>
				</div>

				<input type="submit" id="submit" name="submit" class="btn btn-primary pull-right" value="Submit">
				{!! Form::close() !!}
			</div>
		</div>
	</div>

@endsection