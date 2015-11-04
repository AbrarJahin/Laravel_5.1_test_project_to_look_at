@extends('layouts.admin.master')

@section('contents')
<div class="panel panel-default">
	<div class="panel-heading">Streaming Servers <a href="{{route('streaming-servers.create')}}" class="btn btn-success pull-right">Create New</a> </div>
		<div class="panel-body">
			<table class="table table-bordered">
				<thead>
					<td>Name</td>
					<td>Streaming Url</td>
					<td>Access Level</td>
					<td>Enabled</td>
					<td>Health</td>
					<td>Last Checked</td>
					<td>#</td>
				</thead>
				<tbody>
					@foreach($streaming_servers as $server)
						<tr>
							<td>{!! $server->name !!}</td>
							<td>{!! $server->streaming_url !!}</td>
							<td>{!! $server->access_level !!}</td>
							<td>{!! $server->enabled == 1 ? "Enabled" : "Disabled" !!}</td>
							<td>{!! $server->health == 1 ? "Online" : "Offline" !!}</td>
							<td>{!! $server->last_checked !!}</td>
							<td>
								<a style="color:green" href="{!!route('streaming-servers.update',
													['id' => $server->id])!!}">
									<i class="fa fa-pencil fa-2x"></i>
								</a>
								<a style="color:red" href="{!!route('streaming-servers.delete',
													['id' => $server->id])!!}">
									<i class="fa fa-trash fa-3x"></i>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			{!! $streaming_servers !!}
		</div>
	</div>
</div>
@endsection