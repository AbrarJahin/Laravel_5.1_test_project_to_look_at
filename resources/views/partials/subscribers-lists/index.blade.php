
@extends('layouts.member.master')

@section('contents')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">		<!-- href="{{route('users.subscribers-lists.index', $user->id)}}"  -->
			<div class="panel-heading">
				Subscribers list
				<button type="button" id="export_subscriber_list" class="pull-right btn btn-info">Export Subscribers list</button>
				<a class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal">New</a>
			</div>
			<div class="panel-body">
				<!-- <ul class="list-group list-group-minimal">
					@foreach($subscribersLists as $list)
					<li class="list-group-item">
						<a href="{{route('users.subscribers-lists.subscribers.index', [$user->id, $list->id])}}">
							<span class="badge badge-roundless badge-info pull-right" style="margin: 0">{{$list->subscribers->count()}}
								Subscribers
							</span>
						</a>
						{{$list->name}}
					</li>
					@endforeach
				</ul> -->
				<table id="subscribers_list"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
					<thead>
						<meta name="base_url" content="{{URL::to('/')}}">
						<tr>
							<th>	List Name		</th>
							<th>	Count Openers	</th>
							<th>	Count Clickers	</th>
							<th>	Count Active	</th>
							<th>	Count Unsubsribers	</th>
							<th>	Count Bounce	</th>
							<th>	Count Total	</th>
							<th>	Last Activity	</th>
							<th>	Action</th>
							<th style="width: 1px;"><input type="checkbox" name="select_all" id="select_all"></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>

		<!-- ////////////////////////////////////////////// Charts Start-->
		<div class="panel panel-default">
			<div class="panel-heading">Total Statistics (in chart)</div>
			<div class="panel-body">
				<div class="col-sm-12 text-center pagination-centered">
				  <div id="piechart_total" style="width: 100%; height: 100%;">
				    <!-- Chart goes here -->
				  </div>
				</div>
			</div>
		</div>
		<!-- //////////////////////////////////////////////// Charts End-->

		<div class="panel panel-default">
			<div class="panel-heading">
				Subscribers list by members
				<button type="button" id="export_subscriber_list_members" class="pull-right btn btn-info">Export Subscribers list By Members</button>
			</div>
			<div class="panel-body">
				<div class="col-sm-12 text-center pagination-centered">
				  <table id="subscribers_list_by_members"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
				  	<thead>
				  		<meta name="base_url" content="{{URL::to('/')}}">
				  		<tr>
				  			<th>	List Name		</th>
				  			<th>	Count Openers	</th>
				  			<th>	Count Clickers	</th>
				  			<th>	Count Active	</th>
				  			<th>	Count Unsubsribers	</th>
				  			<th>	Count Bounce	</th>
				  			<th>	Count Total	</th>
				  			<th>	Last Activity	</th>
				  			<th>	Action</th>
				  		</tr>
				  	</thead>
				  </table>
				</div>
			</div>
		</div>
	</div>

	

	<div class="col-md-12">
		@yield('subscribers-contents')
	</div>
</div>
@endsection