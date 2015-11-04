@extends('partials.subscribers-lists.index')

@section('subscribers-contents')
<div class="panel panel-default">
	<div class="panel-heading">Edit {{$subscriber->first_name}}. Subscriber in ({{$subscribersList->name}})</div>
	<div class="panel-body">
			{!! Form::open(
				['url' => route('users.subscribers-lists.subscribers.update',
							[$userId,$subscribersListId,$subscriberId]),
					'method' => 'PUT', 'id' => 'subscriberslist-create-form'])!!}
				<div class="form-group">
					<label for="name">First Name</label>
					<input name="first_name" type="text" class="form-control" value="{{$subscriber->first_name}}"/>
				</div>
				<div class="form-group">
					<label for="name">Last Name</label>
					<input name="last_name" type="text" class="form-control" value="{{$subscriber->last_name}}"/>
				</div>
				<div class="form-group">
					<label for="name">Email</label>
					<input name="email" type="text" class="form-control" value="{{$subscriber->email}}"/>
				</div>
				<div class="form-group">
					<label for="name">Status</label>
					<select name="status" id="" class="form-control">
						<option value="active" @if($subscriber->status == 'active') selected @endif>Active</option>
						<option value="inactive" @if($subscriber->status == 'inactive') selected @endif>Inactive</option>
						<option value="bounced" @if($subscriber->status == 'bounced') selected @endif>Bounced</option>
					</select>
				</div>				
				<button id="manage-registrants-submit" class="btn btn-primary">submit</button>
			{!! Form::close(); !!}
			@include('errors.form')
			<div class="hidden alert alert-success pull-right" id="subscriber-success"> subscribers have been imported successfully </div>
			<div class="hidden alert alert-danger pull-right" id="subscriber-error"> subscribers were not imported successfully </div>
	</div>
</div>
@endsection