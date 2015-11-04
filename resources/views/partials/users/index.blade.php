@extends('layouts.admin.master')

@section('contents')
<div class="panel panel-default">
	<div class="panel-heading">Users</div>
		<nav>
            <br>
			<a href="/users?role=admin"><div class="label label-info">Admins</div></a>
			<a href="/users?role=customer"><div class="label label-purple">Customers</div></a>
			<a href="/users"><div class="label label-success">All</div></a>
		</nav>
		<div class="panel-body">
			<table class="table table-bordered">
				<thead>
					<td>ID</td>
					<td>Name</td>
					<td>Email</td>
					<td>Role</td>
					<td>Status</td>
					<td>#</td>
				</thead>
				<tbody>
					@foreach($users as $user)
						<tr>
							<td>{!! $user->id !!}</td>
							<td>{!! $user->name !!}</td>
							<td>{!! $user->email !!}</td>
							<td>{!! $user->role !!}</td>
							<td>{!! $user->enabled == 1 ? "Enabled" : "Disabled" !!}</td>
							<td><a href="{{route('users.edit', $user->id)}}">Edit</a></td>
						</tr>
					@endforeach
				</tbody>
			</table>
			{!! $users !!}
		</div>
	</div>
</div>
@endsection