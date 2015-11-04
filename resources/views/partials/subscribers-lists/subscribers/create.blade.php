<div class="panel panel-default">
	<div class="panel-heading">Import Subscribers</div>
	<div class="panel-body">
			{!! Form::open(
				['url' => route('users.subscribers-lists.subscribers.store',
							[$userId,$subscribersListId]),
					'method' => 'POST', 'id' => 'subscriberslist-create-form'])!!}
				<div class="form-group">
					<textarea 
						name="subscribers-import" 
						id="subscribers-import" 
						cols="30" rows="10" 
						class="form-control" placeholder="FirstName,LastName,Email
FirstName,LastName,Email"></textarea>
				</div>
				<button id="manage-registrants-submit" class="btn btn-primary">submit</button>
			{!! Form::close(); !!}
			<div class="hidden alert alert-success pull-right" id="subscriber-success"> subscribers have been imported successfully </div>
			<div class="hidden alert alert-danger pull-right" id="subscriber-error"> subscribers were not imported successfully </div>
	</div>
</div>
@section('scripts')
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript" src="{{url('scripts/import-registrants.js')}}"></script>
@endsection