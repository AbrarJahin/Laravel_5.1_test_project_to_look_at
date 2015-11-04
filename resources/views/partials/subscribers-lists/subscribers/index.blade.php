@extends('partials.subscribers-lists.index')

@section('contents')	<!-- subscribers-contents=>contents -->

<div class="panel panel-default">
	<div class="panel-heading">Title of ({{$subscribersList->name}})</div>
	<div class="panel-body">
		<div class="col-md-12">

			{!! Form::open(['url' => route('users.subscribers-lists.update', [$user->id, $subscribersList->id] ), 'method' => 'PATCH', 'class' => 'form-inline']) !!}
            <div class="form-group">
                {!! Form::text('name', $subscribersList->name, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Submit', ['class' => 'btn btn-success btn-single']) !!}
            </div>
            {!! Form::close() !!}

		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">Subscribers of ({{$subscribersList->name}})</div>

	<div class="panel-body">
		<div class="col-md-12">
<!--
			<table class="table table-bordered">
				<thead>
					<td>ID</td>
					<td>First Name</td>
					<td>Last Name</td>
					<td>Email</td>
					<td>Status</td>
					<td>Last Activity</td>
					<td>Action</td>
				</thead>
				<tbody>
					@foreach($subscribers as $subscriber)
						<tr>
							<td>{{$subscriber->id}}</td>
							<td>{{$subscriber->first_name}}</td>
							<td>{{$subscriber->last_name}}</td>
							<td>{{$subscriber->email}}</td>
							<td>{{$subscriber->status}}</td>
							<td>{{$subscriber->updated_at}}</td>
							<td>
								<a style="color:green" href="{!!route('users.subscribers-lists.subscribers.edit',
													[$userId,$subscribersListId,$subscriber->id])!!}">
									<i class="fa fa-pencil fa-2x"></i>
								</a>
								<a style="color:red" href="{!!route('users.subscribers-lists.subscribers.destroy',
													[$userId,$subscribersListId,$subscriber->id])!!}">
									<i class="fa fa-trash fa-3x"></i>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
-->
			<table id="subscribers_names"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
				<thead>
					<meta name="base_url" content="{{URL::to('/')}}">
					<tr>
						<th>	First Name		</th>
						<th>	Last Name		</th>
						<th>	Email			</th>
						<th>	Status			</th>
                                                <th>	UUID			</th>
						<th>	Last Activity	</th>
						<th>	Action			</th>
					</tr>
				</thead>
			</table>

		</div>
		{!!$subscribers!!}
	</div>
</div>

<!-- ////////////////////////////////////////////// Charts Start-->
<div class="panel panel-default">
	<div class="panel-heading">Statistics of ({{$subscribersList->name}})</div>
	<div class="panel-body">
		<div class="col-sm-12 text-center pagination-centered">
		  <!-- <div id="piechart"> -->
		  <div id="piechart" style="width: 100%; height: 100%;">
		    <!-- Chart goes here -->
		  </div>
		</div>
	</div>
</div>
<!-- //////////////////////////////////////////////// Charts End-->

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Create A new List.</h4>
			</div>
			{!! Form::open(['url' => route('users.subscribers-lists.store',$user->id)]) !!}
			<div class="modal-body">
				<div class="form-group">
					<input type="text" class="form-control" id="name" name="name" placeholder="List name">
				</div>
				<div class="form-group">
					<textarea class="form-control" placeholder="Description" name="description" id="" cols="30" rows="10"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<input type="submit" id="submit" name="submit" value="Add" class="btn btn-primary pull-right">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
			</form>
		</div>

	</div>
</div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="{{asset('assets/members/js/custom/chart.js')}}"></script>

@include('partials.subscribers-lists.subscribers.create')
@endsection