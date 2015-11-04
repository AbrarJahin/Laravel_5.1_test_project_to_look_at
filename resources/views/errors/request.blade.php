@if($errors->has('error'))
	@foreach($errors->all() as $error)
		<div class="alert alert-danger">
	       <strong>Invalid Request</strong> {!! $error !!}
	    </div>
	@endforeach
@endif