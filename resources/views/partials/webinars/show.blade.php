@extends('partials.subscribers-lists.index')

@section('subscribers-contents')
<div class="panel panel-default">
	<div class="panel-heading">{{$webinar->title}}</div>
	<div class="panel-body">
		<div class="col-md-12">
			<section>
				<label for="" class="label label-info">Description</label>
				{{$webinar->description}}
			</section>
			<hr>
			<section>
				<label for="" class="label label-info">Share</label>
				{{$webinar->share}}
			</section>
			<hr>
			<section>
				<label for="" class="label label-info">Starts on</label>
				{{$webinar->starts_on}}
			</section>
			<hr>
			<section>
				<label for="" class="label label-info">Ends on</label>
				{{$webinar->ends_on}}
			</section>
			<hr>
			<section>
				<label for="" class="label label-info">Subscriber's lists</label>
				@foreach($webinar->subscribers_lists as $list) 
					<ul>
						<li>{{$list->name}}</li>
					</ul>
				@endforeach
			</section>
			<a href="{{route('users.webinars.edit',[$user->id,$webinar->uuid])}}" class="btn btn-primary">Edit</a>
		</div>
	</div>
</div>

@section('scripts')
	
@endsection

@endsection